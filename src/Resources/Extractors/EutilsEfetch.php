<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Helpers\DateHelper;

class EutilsEfetch implements Extractor, ProvidesPublicationData, ProvidesIdentifiersData, ProvidesAuthorsData, ProvidesJournalData
{
    private $document;

    private $searchTree;

    private $output = [];
    private $identifier;

    public function __construct($document, $identifier)
    {
        $this->document = $document;
        $this->identifier = $identifier;
    }

    public function extract(): array
    {
        $this->getDataFromDocument();

        $this->extractAuthorsData();
        $this->extractIdentifiersData();
        $this->extractJournalData();
        $this->extractPublicationData();

        return $this->output;
    }

    protected function getDataFromDocument()
    {
        $this->searchTree = $this->document->{'PubmedArticle'};
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData()
    {
        $this->output['publication'] = [
            'title' => (string) $this->searchTree->MedlineCitation->Article->ArticleTitle ?? null,
            'url' => (string) 'http://www.ncbi.nlm.nih.gov/pubmed/'.$this->searchTree->MedlineCitation->PMID,
            'published_at' => (new DateHelper)->dateFromPubDate($this->searchTree->MedlineCitation->Article->Journal->JournalIssue->PubDate),
            'abstract' => (string) $this->searchTree->MedlineCitation->Article->Abstract->AbstractText ?? null,
        ];
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData()
    {
        foreach ($this->searchTree->PubmedData->ArticleIdList->ArticleId as $identifier) {
            $this->output['identifiers'][] = [
                'value' => (string) $identifier,
                'type' => (string) $identifier['IdType'],
            ];
        }

        if ($this->searchTree->MedlineCitation->Article->Journal->ISSN) {
            $this->output['identifiers'][] = [
                'value' => (string) $this->searchTree->MedlineCitation->Article->Journal->ISSN,
                'type' => 'issn',
            ];
        }
    }

    /**
     * Extract and format data needed for the Journals Relationship
     * on the Publication Model.
     */
    public function extractJournalData()
    {
        $issn = [];

        if ($this->searchTree->MedlineCitation->Article->Journal->ISSN) {
            $issn[] = $this->searchTree->MedlineCitation->Article->Journal->ISSN;
        }

        if ($this->searchTree->MedlineCitation->MedlineJournalInfo->ISSNLinking) {
            $issn[] = $this->searchTree->MedlineCitation->MedlineJournalInfo->ISSNLinking;
        }

        $this->output['journals'] = [
            'title' => (string) $this->searchTree->MedlineCitation->Article->Journal->Title ?? null,
            'issn' => $issn,
        ];
    }

    /**
     * Extract and format data needed for the Authors Relationship
     * on the Publication Model.
     */
    public function extractAuthorsData()
    {
        try {
            foreach ($this->searchTree->MedlineCitation->Article->AuthorList->Author as $author) {
                $this->output['authors'][] = [
                    'first_name' => (string) $author->ForeName,
                    'last_name' => (string) $author->LastName,
                    'affiliation' => (string) $author->AffiliationInfo->Affiliation,
                ];
            }
        } catch (\Exception $e) {
            // If can't find authors, just don't do anything.
        }
    }
}
