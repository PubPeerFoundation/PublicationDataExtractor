<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use SimpleXMLElement;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class Arxiv implements Resource
{
    /**
     * @var string
     */
    protected $url = 'http://export.arxiv.org/api/query';

    /**
     * @var array
     */
    protected $queryStringParameters = [
        'query' => [
            'id_list' => '',
        ],
    ];

    /**
     * Arxiv constructor.
     * @param Identifier $identifier
     */
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
