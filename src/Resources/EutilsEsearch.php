<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

class EutilsEsearch extends Resource
{
    /**
     * @var string
     */
    protected $url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi';

    /**
     * @var array
     */
    protected $queryStringParameters = [
        'query' => [
            'db' => 'pubmed',
            'version' => '2.0',
            'retmode' => 'json',
            'term' => '',
            'field' => 'AID',
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
            $baseTree = json_decode($document, true);
            $extractor = new Extractors\EutilsEsearch($baseTree, $this->output);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
