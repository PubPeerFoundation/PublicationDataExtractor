<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class Pubmed extends Identifier
{
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\EutilsEfetch::class,
        \PubPeerFoundation\PublicationDataExtractor\Resources\IdConverter::class,
    ];

    protected $regex = '/^\d{5,8}$/';

    protected $baseUrl = 'http://www.ncbi.nlm.nih.gov/pubmed/';
}
