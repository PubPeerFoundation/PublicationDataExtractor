<?php

namespace XavRsl\PublicationDataExtractor\Resources;

class Doi extends Crossref
{
    /**
     * Base query URL.
     *
     * @var string
     */
    protected $url = 'http://dx.doi.org/';

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
