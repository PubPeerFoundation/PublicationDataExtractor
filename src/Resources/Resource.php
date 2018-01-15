<?php

namespace XavRsl\PublicationDataExtractor\Resources;

interface Resource
{
    /**
     * Full URL to the fetched resource.
     *
     * @return string
     */
    public function getApiUrl(): string;

    /**
     * Request Options Array used to fetch the resource.
     *
     * @return array
     */
    public function getRequestOptions(): array;

    /**
     * Transform raw data to a usable format.
     *
     * @param string $document
     * @return array
     */
    public function getDataFrom(string $document): array;
}
