<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class PubmedWebsite implements Resource
{
    protected $url = 'https://www.ncbi.nlm.nih.gov/pubmed/';

    protected $queryStringParameters = [
        'query' => [
            'term' => '',
        ],
    ];

    protected $input;

    protected $identifier;

    public function __construct(Identifier $identifier)
    {
        $this->queryStringParameters['query']['term'] = $identifier->getQueryString();
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->url;
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
        try {
            $extractor = new Extractors\PubmedWebsite($document);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
