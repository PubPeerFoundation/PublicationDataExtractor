<?php

namespace XavRsl\PublicationDataExtractor\Identifiers;

use XavRsl\PublicationDataExtractor\Identifier;

class Doi extends Identifier
{
    /**
     * Resource array.
     *
     * @var array
     */
    protected $resources = [
        \XavRsl\PublicationDataExtractor\Resources\Doi::class,
        \XavRsl\PublicationDataExtractor\Resources\Crossref::class,
    ];

    /**
     * new RegExp found: https://stackoverflow.com/questions/27910/finding-a-doi-in-a-document-or-page:.
     *
     * @var string
     */
    protected $regex = '/\b(10[.][0-9]{3,}(?:[.][0-9]+)*\/(?:(?!["&\'])\S)+)\b/';

    /**
     * Get URL based on Identifier.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return 'http://dx.doi.org/'.$this->getQueryString();
    }

    /**
     * QueryString getter.
     *
     * @return string
     */
    public function getQueryString(): string
    {
        return rtrim($this->matches[0], ' .');
    }
}
