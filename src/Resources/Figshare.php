<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

class Figshare extends Doi
{
    /**
     * @var string
     */
    protected $extractor = Extractors\Figshare::class;
}
