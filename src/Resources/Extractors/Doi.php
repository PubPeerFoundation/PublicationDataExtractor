<?php

namespace XavRsl\PublicationDataExtractor\Resources\Extractors;

use XavRsl\PublicationDataExtractor\Exceptions\UnparseableApiException;

class Doi implements Extractor, ProvidesPublicationData, ProvidesIdentifiersData, ProvidesJournalsData, ProvidesAuthorsData
{
    /**
     * @var
     */
    private $document;

    private $searchTree;

    private $output = [];

    public function __construct($document)
    {
        $this->document = $document;
    }

    public function extract(): array
    {
        $this->searchTree = json_decode($this->document, true);

        if (is_null($this->searchTree)) {
            throw new UnparseableApiException();
        }

        $this->extractAuthorsData();
        $this->extractIdentifiersData();
        $this->extractJournalsData();
        $this->extractPublicationData();

        return $this->output;
    }

    public function extractAuthorsData()
    {
        // TODO: Implement extractAuthorsData() method.
    }

    public function extractIdentifiersData()
    {
        // TODO: Implement extractIdentifiersData() method.
    }

    public function extractJournalsData()
    {
        // TODO: Implement extractJournalsData() method.
    }

    public function extractPublicationData()
    {
        // TODO: Implement extractPublicationData() method.
    }
}
