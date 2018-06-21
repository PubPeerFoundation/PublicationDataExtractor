<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

class Doi extends Crossref
{
    /**
     * Base query URL.
     *
     * @var string
     */
    protected $url = 'https://doi.org/';

    /**
     * Parameters needed for the query.
     *
     * @var array
     */
    protected $queryStringParameters = [
        'headers' => ['Accept' => 'application/vnd.citationstyles.csl+json;q=1.0'],
    ];

    protected $extractor = Extractors\Doi::class;
}
