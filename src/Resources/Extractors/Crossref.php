<?php

namespace XavRsl\PublicationDataExtractor\Resources\Extractors;

use SimpleXMLElement;
use XavRsl\PublicationDataExtractor\Exceptions\UnparseableApiException;

class Crossref implements Extractor, ProvidesPublicationData, ProvidesIdentifiersData, ProvidesJournalsData, ProvidesAuthorsData
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
        $tree = new SimpleXMLElement($this->document);
        $baseTree = $tree->{'query_result'}->body->query;

        if ('unresolved' === (string) $baseTree['status']
            || null == $baseTree->doi_record->crossref->journal->{'journal_article'}) {
            throw new UnparseableApiException();
        }

        $this->searchTree = $baseTree->doi_record->crossref->journal;

        $this->extractAuthorsData();
        $this->extractIdentifiersData();
        $this->extractJournalsData();
        $this->extractPublicationData();

        return $this->output;
    }

    public function extractPublicationData()
    {
        // TODO: Implement extractPublicationData() method.
    }

    public function extractIdentifiersData()
    {
        // TODO: Implement extractIdentifiersData() method.
    }

    public function extractAuthorsData()
    {
        // TODO: Implement extractAuthorsData() method.
    }

    public function extractJournalsData()
    {
        // TODO: Implement extractJournalsData() method.
    }
}
