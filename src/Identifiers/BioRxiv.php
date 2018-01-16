<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class BioRxiv extends Doi
{
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\BioRxiv::class,
    ];

    protected $regex = '/(10.1101\/(?:([[:alnum:]]|-|\(|\)|\.|\/))+)/';
}
