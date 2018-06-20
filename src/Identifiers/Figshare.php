<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class Figshare extends Doi
{
    /**
     * @var array
     */
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\Figshare::class,
    ];

    /**
     * @var string
     */
    protected $regex = '/\b(10[.][0-9]{3,}(?:[.][0-9]+)*\/(?:(?!["&\'])\S)+figshare(?:(?!["&\'])\S)+)\b/';
}
