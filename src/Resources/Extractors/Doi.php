<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

class Doi extends Crossref
{
    /**
     * Create search tree.
     */
    protected function fillSearchTree(): void
    {
        $this->searchTree = $this->document;
    }
}
