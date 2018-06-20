<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

class Doi extends Crossref
{
    /**
     * Create search tree.
     */
    protected function getDataFromDocument()
    {
        $this->searchTree = $this->document;
    }
}
