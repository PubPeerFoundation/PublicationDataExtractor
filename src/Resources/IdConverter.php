<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

class IdConverter extends Resource
{
    /**
     * @var string
     */
    protected $url = 'https://www.ncbi.nlm.nih.gov/pmc/utils/idconv/v1.0/';

    /**
     * @var array
     */
    protected $queryStringParameters = [
        'query' => [
            'format' => 'json',
            'tool' => 'pubpeer',
            'email' => 'contact@pubpeer.com',
            'version' => 'no',
            'ids' => '',
        ],
    ];

    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        $this->queryStringParameters['query']['ids'] = $this->identifier->getQueryString();

        return $this->queryStringParameters;
    }

    /**
     * @param  string  $document
     * @return array
     */
    public function getDataFrom(string $document): array
    {
        try {
            $baseTree = json_decode($document, true);
            $extractor = new Extractors\IdConverter($baseTree, $this->output);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
