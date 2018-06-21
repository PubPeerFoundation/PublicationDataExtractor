<?php

namespace PubPeerFoundation\PublicationDataExtractor;

use Generator;
use Tightenco\Collect\Support\Arr;
use GuzzleHttp\Promise\EachPromise;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use PubPeerFoundation\PublicationDataExtractor\Models\Output;
use PubPeerFoundation\PublicationDataExtractor\Resources\Resource;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class ApiDataFetcher
{
    /**
     * @var Identifier
     */
    protected $identifier;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $apiData = [];

    /**
     * @var array
     */
    protected $resources = [];

    /**
     * @var array
     */
    protected $resourcesToFetch = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * ApiDataFetcher constructor.
     *
     * @param Identifier $identifier
     */
    public function __construct(Identifier $identifier)
    {
        $this->identifier = $identifier;
        $this->resourcesToFetch = $identifier->getRelatedResources();
        $this->client = GuzzleFactory::make(compact('headers'), 100);
    }

    /**
     * Fetch data from API calls promises.
     */
    public function fetch(): void
    {
        (new EachPromise($this->getPromises(), [
            'concurrency' => 5,
            'fulfilled' => function (ResponseInterface $response, $index) {
                $this->apiData[] = $this->getResourceAtIndex($index)
                    ->getDataFrom((string) $response->getBody());
            },
            'rejected' => function (RequestException $exception, $index) {
                $resourceName = get_class_name($this->getResourceAtIndex($index));
                $this->errors[$resourceName] = $exception->getCode();
            },
        ]))->promise()->wait();
    }

    /**
     * Get list of API calls promises.
     *
     * @return Generator
     */
    protected function getPromises(): Generator
    {
        foreach ($this->resourcesToFetch as $resourceClass) {
            $resource = $this->instantiateResource($resourceClass);

            $promise = $this->client->requestAsync(
                'GET',
                $resource->getApiUrl(),
                $resource->getRequestOptions()
            );

            yield $promise;
        }
    }

    /**
     * Get the whole data array.
     *
     * @return array
     */
    public function getData(): array
    {
        if (0 === count(array_filter(Arr::pluck($this->apiData, 'publication')))) {
            return [];
        }

        $this->fetchComplementaryData();

        return Output::getInstance()->format();
    }

    /**
     * Get errors as array.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get resource instance from resources array.
     *
     * @param int $index
     *
     * @return resource
     */
    protected function getResourceAtIndex(int $index): Resource
    {
        return $this->resources[$index];
    }

    /**
     * Create and store an instance of the Resource class.
     *
     * @param string $resourceClass
     *
     * @return resource
     */
    protected function instantiateResource($resourceClass): Resource
    {
        return $this->resources[] = new $resourceClass($this->identifier);
    }

    /**
     * Fetch again with new related Identifiers.
     */
    protected function fetchComplementaryData()
    {
        $flatIdentifiers = Arr::flatten(Arr::pluck($this->apiData, 'identifiers'));

        foreach ($this->identifier->getComplementaryResources() as $key => $value) {
            if (false !== $valueKey = array_search($key, $flatIdentifiers)) {
                try {
                    $this->identifier = (new IdentifierResolver($flatIdentifiers[$valueKey - 1]))->handle();

                    $this->resourcesToFetch = [$value];
                    $this->resources = [];

                    $this->fetch();
                } catch (Exceptions\UnknownIdentifierException $e) {
                    continue;
                }
            }
        }
    }
}
