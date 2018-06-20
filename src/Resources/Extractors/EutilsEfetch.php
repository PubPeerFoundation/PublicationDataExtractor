<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

class EutilsEfetch implements Extractor, ProvidesPublicationData, ProvidesIdentifiersData, ProvidesAuthorsData, ProvidesJournalData
{
    /**
     * @var array
     */
    protected $document;

    /**
     * @var array
     */
    protected $searchTree;

    /**
     * @var array
     */
    protected $output = [];

    /**
     * EutilsEfetch constructor.
     *
     * @param $document
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * @return array
     */
    public function extract(): array
    {
        $this->getDataFromDocument();

        $this->extractAuthorsData();
        $this->extractIdentifiersData();
        $this->extractJournalData();
        $this->extractPublicationData();

        return $this->output;
    }

    /**
     * Create search tree.
     */
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
            'title' => get_string($this->searchTree, 'MedlineCitation.Article.ArticleTitle'),
            'url' => (string) 'http://www.ncbi.nlm.nih.gov/pubmed/'.get_string($this->searchTree, 'MedlineCitation.PMID'),
            'published_at' => date_from_pub_date(data_get($this->searchTree, 'MedlineCitation.Article.Journal.JournalIssue.PubDate')),
            'abstract' => get_string($this->searchTree, 'MedlineCitation.Article.Abstract.AbstractText'),
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
        if ($value = get_string($this->searchTree, 'MedlineCitation.Article.Journal.ISSN')) {
            $this->output['identifiers'][] = [
                'value' => $value,
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
        $this->output['journal'] = [
            'title' => get_string($this->searchTree, 'MedlineCitation.Article.Journal.Title'),
            'issn' => $this->getIssns(),
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
                    'first_name' => get_string($author, 'ForeName'),
                    'last_name' => get_string($author, 'LastName'),
                    'affiliation' => get_string($author, 'AffiliationInfo.Affiliation'),
                ];
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Get all available ISSNs values from the tree.
     *
     * @return array
     */
    protected function getIssns()
    {
        $issn = [];

        if ($number = get_string($this->searchTree, 'MedlineCitation.Article.Journal.ISSN')) {
            $issn[] = $number;
        }

        if ($number = get_string($this->searchTree, 'MedlineCitation.MedlineJournalInfo.ISSNLinking')) {
            $issn[] = $number;
        }

        return $issn;
    }
}
