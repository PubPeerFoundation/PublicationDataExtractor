<?php

namespace XavRsl\PublicationDataExtractor\Resources;

use SimpleXMLElement;
use XavRsl\PublicationDataExtractor\Identifiers\Identifier;

class EutilsEfetch implements Resource
{
    protected $url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi';

    protected $queryStringParameters = [
        'query' => [
            'db' => 'pubmed',
            'version' => '2.0',
            'retmode' => 'xml',
            'id' => '',
        ],
    ];

    protected $input;

    protected $identifier;

    public function __construct(Identifier $identifier)
    {
        $this->queryStringParameters['query']['id'] = $identifier->getQueryString();
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
            $extractor = new Extractors\EutilsEfetch($baseTree, $this->identifier);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }
}
