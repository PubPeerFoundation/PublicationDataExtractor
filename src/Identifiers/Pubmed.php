<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class Pubmed extends Identifier
{
    /**
     * @var array
     */
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\EutilsEfetch::class,
        \PubPeerFoundation\PublicationDataExtractor\Resources\IdConverter::class,
    ];

    /**
     * @var array
     */
    protected $complementaryResources = [
        'doi' => \PubPeerFoundation\PublicationDataExtractor\Resources\Crossref::class,
    ];

    /**
     * @var string
     */
    protected $regex = '/^\d{5,8}$/';

    /**
     * @var string
     */
    protected $baseUrl = 'http://www.ncbi.nlm.nih.gov/pubmed/';
}
