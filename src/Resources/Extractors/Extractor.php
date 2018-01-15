<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

interface Extractor
{
    public function extract(): array;
}
