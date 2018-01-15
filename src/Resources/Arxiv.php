<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use SimpleXMLElement;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class Arxiv implements Resource
{
    protected $url = 'http://export.arxiv.org/api/query';

    protected $queryStringParameters = [
        'query' => [
            'id_list' => '',
        ],
    ];

    protected $input;

    protected $identifier;

    public function __construct(Identifier $identifier)
    {
        $this->queryStringParameters['query']['id_list'] = $identifier->getQueryString();
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
            $baseTree = new SimpleXMLElement($document);
            $extractor = new Extractors\Arxiv($baseTree);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
