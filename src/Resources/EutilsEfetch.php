<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use SimpleXMLElement;

class EutilsEfetch extends Resource
{
    /**
     * @var string
     */
    protected $url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi';

    /**
     * @var array
     */
    protected $queryStringParameters = [
        'query' => [
            'db' => 'pubmed',
            'version' => '2.0',
            'retmode' => 'xml',
            'id' => '',
        ],
    ];

    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        $this->queryStringParameters['query']['id'] = $this->identifier->getQueryString();

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
            $extractor = new Extractors\EutilsEfetch($baseTree, $this->output);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
