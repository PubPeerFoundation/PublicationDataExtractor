<?php

namespace XavRsl\PublicationDataExtractor\Resources;

use XavRsl\PublicationDataExtractor\Exceptions\UnparseableApiException;
use XavRsl\PublicationDataExtractor\Identifier;

class Crossref implements Resource
{
    protected $url = 'http://www.crossref.org/openurl/';

    protected $queryStringParameters = [
        'query' => [
            'pid' => 'contact@pubpeer.com',
            'format' => 'unixsd',
            'noredirect' => 'True',
            'id' => '',
        ],
    ];

    protected $input;

    public function __construct(Identifier $identifier)
    {
        $this->queryStringParameters['query']['id'] = $identifier->getQueryString();
    }

    /**
     * @return string
     */
    public function getUrl(): string
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
            $extractor = new Extractors\Crossref($document);

            return $extractor->extract();
        } catch (UnparseableApiException $e) {
            return [];
        }
    }
}
