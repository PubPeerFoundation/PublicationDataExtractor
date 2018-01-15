<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

class Doi extends Crossref
{
    protected function getDataFromDocument()
    {
        $this->searchTree = $this->document;
    }
}
