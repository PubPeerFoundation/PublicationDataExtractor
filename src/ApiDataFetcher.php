<?php

namespace PubPeerFoundation\PublicationDataExtractor;

use Generator;
use GuzzleHttp\Promise\EachPromise;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use PubPeerFoundation\PublicationDataExtractor\Resources\Resource;
use PubPeerFoundation\PublicationDataExtractor\Helpers\ClassHelper;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class ApiDataFetcher
{
    protected $identifier;

    protected $client;

    protected $resources = [];

    public $apiData;

    protected $errors = [];

    public function __construct(Identifier $identifier)
    {
        $this->identifier = $identifier;
        $this->client = GuzzleFactory::make(compact('headers'), 100);
    }

    /**
     * Get data from API calls promises.
     */
    public function getData(): void
    {
        (new EachPromise($this->getPromises(), [
            'concurrency' => 3,
            'fulfilled' => function (ResponseInterface $response, $index) {
                $this->apiData[] = $this->getResourceAtIndex($index)
                    ->getDataFrom((string) $response->getBody());
            },
            'rejected' => function (RequestException $exception, $index) {
                $resourceName = ClassHelper::get_class_name($this->getResourceAtIndex($index));
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
        foreach ($this->identifier->getRelatedResources() as $resourceClass) {
            $resource = $this->instantiateResource($resourceClass);

            $promise = $this->client->requestAsync(
                'GET',
                $resource->getApiUrl(),
                $resource->getRequestOptions()
            );

            yield $promise;
        }
    }

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
}
