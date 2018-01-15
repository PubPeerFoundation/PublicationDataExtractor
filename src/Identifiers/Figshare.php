<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class Figshare extends Doi
{
    protected $resources = [
        'figshare' => \App\Resources\Figshare::class,
    ];

    protected $regex = '/\b(10[.][0-9]{3,}(?:[.][0-9]+)*\/(?:(?!["&\'])\S)+figshare(?:(?!["&\'])\S)+)\b/';
}
