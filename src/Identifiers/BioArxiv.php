<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class BioArxiv extends Doi
{
    protected $resources = [
        'bioarxivdoi' => \App\Resources\BioArxivDoi::class,
    ];

    protected $regex = '/(10.1101\/(?:([[:alnum:]]|-|\(|\)|\.|\/))+)/';
}
