<?php

namespace XavRsl\PublicationDataExtractor\Resources\Extractors;

use SimpleXMLElement;

class Arxiv implements Extractor, ProvidesPublicationData, ProvidesIdentifiersData, ProvidesAuthorsData, ProvidesJournalsData, ProvidesTypesData
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
        $query = new SimpleXMLElement($this->document);

        $this->searchTree = $query->entry;

        return $this->output;
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData()
    {
        $this->output['publication'] = [
            'title' => (string) $this->searchTree->title[0] ?? null,
            'abstract' => (string) $this->searchTree->summary[0] ?? null,
            'url' => (string) $this->searchTree->id[0] ?? null,
        ];
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData()
    {
        $this->output['identifiers'][] = [
            'value' => (string) $this->identifier->getQueryString(),
            'type' => 'arxiv',
        ];
    }

    /**
     * Extract and format data needed for the Journals Relationship
     * on the Publication Model.
     */
    public function extractJournalsData()
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
}
