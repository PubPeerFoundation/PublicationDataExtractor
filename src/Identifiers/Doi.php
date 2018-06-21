<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class Doi extends Identifier
{
    /**
     * Resource array.
     *
     * @var array
     */
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\Doi::class,
        \PubPeerFoundation\PublicationDataExtractor\Resources\Crossref::class,
//        \PubPeerFoundation\PublicationDataExtractor\Resources\PubmedWebsite::class,
        \PubPeerFoundation\PublicationDataExtractor\Resources\IdConverter::class,
        \PubPeerFoundation\PublicationDataExtractor\Resources\EutilsEsearch::class,
    ];

    /**
     * @var array
     */
    protected $complementaryResources = [
        'pubmed' => \PubPeerFoundation\PublicationDataExtractor\Resources\EutilsEfetch::class,
    ];

    /**
     * new RegExp found: https://stackoverflow.com/questions/27910/finding-a-doi-in-a-document-or-page:.
     *
     * @var string
     */
    protected $regex = '/\b(10[.][0-9]{3,}(?:[.][0-9]+)*\/(?:(?!["&\'])\S)+)\b/';

    /**
     * @var string
     */
    protected $baseUrl = 'http://dx.doi.org/';

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
