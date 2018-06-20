<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class BioRxiv extends Doi
{
    /**
     * @var array
     */
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\BioRxiv::class,
    ];

    /**
     * @var string
     */
    protected $regex = '/(10.1101\/(?:([[:alnum:]]|-|\(|\)|\.|\/))+)/';
}
