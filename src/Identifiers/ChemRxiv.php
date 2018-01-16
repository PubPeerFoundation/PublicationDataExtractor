<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class ChemRxiv extends Doi
{
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\ChemRxiv::class
    ];

    protected $regex = '/\b(10[.][0-9]{3,}(?:[.][0-9]+)*\/chemrxiv.(?:(?!["&\'])\S)+)\b/';
}
