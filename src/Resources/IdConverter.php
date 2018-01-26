<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use SimpleXMLElement;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class IdConverter implements Resource
{
    protected $url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi';

    protected $queryStringParameters = [
        'query' => [
            'format' => 'json',
            'tool' => 'pubpeer',
            'email' => 'contact@pubpeer.com',
            'version' => 'no',
            'ids' => ''
        ],
    ];

    protected $input;

    protected $identifier;

    public function __construct(Identifier $identifier)
    {
        $this->queryStringParameters['query']['ids'] = $identifier->getQueryString();
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
            $baseTree = json_decode($document, true);
            $extractor = new Extractors\IdConverter($baseTree);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
