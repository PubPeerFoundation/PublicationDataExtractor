<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use SimpleXMLElement;

class Arxiv extends Resource
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
     * @return array
     */
    public function getRequestOptions(): array
    {
        $this->queryStringParameters['query']['id_list'] = $this->identifier->getQueryString();

        return $this->queryStringParameters;
    }

    /**
     * @param  string  $document
     * @return array
     */
    public function getDataFrom(string $document): array
    {
        try {
            $baseTree = new SimpleXMLElement($document);
            $extractor = new Extractors\Arxiv($baseTree, $this->output);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
