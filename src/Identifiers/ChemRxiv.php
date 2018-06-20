<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class ChemRxiv extends Doi
{
    /**
     * @var array
     */
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\ChemRxiv::class,
    ];

    /**
     * @var string
     */
    protected $regex = '/\b(10[.][0-9]{3,}(?:[.][0-9]+)*\/chemrxiv.(?:(?!["&\'])\S)+)\b/';
}
