<?php

namespace XavRsl\PublicationDataExtractor\Resources;

use XavRsl\PublicationDataExtractor\Exceptions\UnparseableApiException;
use XavRsl\PublicationDataExtractor\Identifier;

class Doi implements Resource
{
    /**
     * Base query URL.
     *
     * @var string
     */
    protected $url = 'http://dx.doi.org/';

    /**
     * Parameters needed for the query.
     *
     * @var array
     */
    protected $queryStringParameters = [
        'headers' => ['Accept' => 'application/vnd.citationstyles.csl+json;q=1.0'],
    ];

    /**
     * Identifier passed in the constructor.
     *
     * @var Identifier
     */
    public $identifier;

    protected $input;

    /**
     * Doi constructor.
     *
     * @param Identifier $identifier
     */
    public function __construct(Identifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Full URL to the fetched resource.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url.$this->identifier->getQueryString();
    }

    /**
     * Request Options Array used to fetch the resource.
     *
     * @return array
     */
    public function getRequestOptions(): array
    {
        return $this->queryStringParameters;
    }

    /**
     * Transform raw data to a usable format.
     *
     * @param string $document
     * @return array
     * @throws UnparseableApiException
     */
    public function getDataFrom(string $document): array
    {
        try {
            $extractor = new Extractors\Doi($document);

            return $extractor->extract();
        } catch (UnparseableApiException $e) {
            return [];
        }
    }
}
