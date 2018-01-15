<?php

namespace XavRsl\PublicationDataExtractor\Resources\Extractors;

use XavRsl\PublicationDataExtractor\Helpers\DateHelper;

class Arxiv implements Extractor, ProvidesPublicationData, ProvidesIdentifiersData, ProvidesAuthorsData, ProvidesJournalData, ProvidesTypesData
{
    private $document;

    private $searchTree;

    private $output = [];

    public function __construct($document)
    {
        $this->document = $document;
    }

    public function extract(): array
    {
        $this->getDataFromDocument();

        $this->extractAuthorsData();
        $this->extractIdentifiersData();
        $this->extractJournalData();
        $this->extractPublicationData();
        $this->extractTypesData();

        return $this->output;
    }

    protected function getDataFromDocument()
    {
        $this->searchTree = $this->document->entry;
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData()
    {
        $this->output['publication'] = [
            'title' => (string) $this->searchTree->title[0] ?? null,
            'abstract' => (string) trim($this->searchTree->summary[0]) ?? null,
            'url' => (string) $this->searchTree->id[0] ?? null,
            'published_at' => (new DateHelper)->dateFromCommonFormat($this->searchTree->published)
        ];
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData()
    {
        $this->output['identifiers'][] = [
            'value' => (string) $this->getIdentifier(),
            'type' => 'arxiv',
        ];

        $this->output['identifiers'][] = [
            'value' => '2331-8422',
            'type' => 'issn',
        ];
    }

    /**
     * Extract and format data needed for the Journals Relationship
     * on the Publication Model.
     */
    public function extractJournalData()
    {
        $this->output['journals'] = [
            'title' => 'arXiv',
            'issn' => ['2331-8422'],
        ];
    }

    /**
     * Extract and format data needed for the Authors Relationship
     * on the Publication Model.
     */
    public function extractAuthorsData()
    {
        foreach ($this->searchTree->author as $author) {
            $name = explode(' ', $author->name, 2);
            $this->output['authors'][] = [
                'first_name' => $name[0] ?? null,
                'last_name' => $name[1] ?? null,
            ];
        }
    }

    /**
     * Extract and format data needed for the Types Relationship
     * on the Publication Model.
     */
    public function extractTypesData()
    {
        $this->output['types'][] = [
            'name' => 'arxiv',
        ];
    }

    protected function getIdentifier()
    {
        $urlParts = explode('/', $this->searchTree->id[0]);
        return array_pop($urlParts);
    }
}
