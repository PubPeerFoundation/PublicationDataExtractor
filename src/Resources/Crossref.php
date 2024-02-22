<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class Crossref extends Resource
{
    /**
     * @var string
     */
    protected $url = 'https://api.crossref.org/works/';

    /**
     * @var array
     */
    protected $queryStringParameters = [
        'headers' => [
            'User-Agent' => 'PubPeer/2.0 (https://pubpeer.com; mailto:contact@pubpeer.com)',
        ],
    ];

    /**
     * @var string
     */
    protected $extractor = Extractors\Crossref::class;

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->url.$this->identifier->getQueryString();
    }

    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        return $this->queryStringParameters;
    }

    /**
     * @param  string  $document
     * @return array
     */
    public function getDataFrom(string $document): array
    {
        $baseTree = json_decode($document, true);

        if (is_null($baseTree)) {
            return [];
        }

        try {
            $extractor = new $this->extractor($baseTree, $this->output);

            return $extractor->extract();
        } catch (UnparseableApiException $e) {
            return [];
        }
    }
}
