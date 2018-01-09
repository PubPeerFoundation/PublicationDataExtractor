<?php

namespace XavRsl\PublicationDataExtractor\Resources\Extractors;

interface Extractor
{
    public function extract(): array;
}
