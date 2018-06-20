<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class EutilsEsearch implements Resource
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
     * EutilsEsearch constructor.
     *
     * @param Identifier $identifier
     */
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
            $baseTree = json_decode($document, true);
            $extractor = new Extractors\EutilsEsearch($baseTree);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
