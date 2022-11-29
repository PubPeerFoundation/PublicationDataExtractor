<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

class PubmedWebsite extends Resource
{
    /**
     * @var string
     */
    protected $url = 'https://www.ncbi.nlm.nih.gov/pubmed/';

    /**
     * @var array
     */
    protected $queryStringParameters = [
        'query' => [
            'term' => '',
        ],
    ];

    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        $this->queryStringParameters['query']['term'] = $this->identifier->getQueryString();

        return $this->queryStringParameters;
    }

    /**
     * @param  string  $document
     * @return array
     */
    public function getDataFrom(string $document): array
    {
        try {
            $extractor = new Extractors\PubmedWebsite($document, $this->output);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
