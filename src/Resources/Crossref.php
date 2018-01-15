<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class Crossref implements Resource
{
    protected $url = 'https://api.crossref.org/works/';

    protected $queryStringParameters = [
        'headers' => [
            'User-Agent'    =>  'PubPeer/2.0 (https://pubpeer.com; mailto:contact@pubpeer.com)'
        ]
    ];

    protected $input;

    protected $identifier;

    protected $extractor = Extractors\Crossref::class;

    public function __construct(Identifier $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->url . $this->identifier->getQueryString();
    }

    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        return $this->queryStringParameters;
    }

    /**
     * @param string $document
     *
     * @return array
     */
    public function getDataFrom(string $document): array
    {
        $baseTree = json_decode($document, true);

        if (is_null($baseTree)) {
            return [];
        }

        try {
            $extractor = new $this->extractor($baseTree);

            return $extractor->extract();
        } catch (UnparseableApiException $e) {
            return [];
        }
    }
}
