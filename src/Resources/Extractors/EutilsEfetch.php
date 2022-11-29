<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Support\UpdateTypesStandardiser;
use Tightenco\Collect\Support\Arr;

class EutilsEfetch extends Extractor implements ProvidesPublicationData, ProvidesIdentifiersData, ProvidesAuthorsData, ProvidesJournalData, ProvidesUpdatesData
{
    /**
     * Create search tree.
     */
    protected function fillSearchTree(): void
    {
        $this->searchTree = $this->document->{'PubmedArticle'};
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData(): void
    {
        $this->resourceOutput['publication'] = [
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
    public function extractIdentifiersData(): void
    {
        foreach ($this->searchTree->PubmedData->ArticleIdList->ArticleId as $identifier) {
            $this->resourceOutput['identifiers'][] = [
                'value' => (string) $identifier,
                'type' => (string) $identifier['IdType'],
            ];
        }
        if ($value = get_string($this->searchTree, 'MedlineCitation.Article.Journal.ISSN')) {
            $this->resourceOutput['identifiers'][] = [
                'value' => $value,
                'type' => 'issn',
            ];
        }
    }

    /**
     * Extract and format data needed for the Journals Relationship
     * on the Publication Model.
     */
    public function extractJournalData(): void
    {
        $this->resourceOutput['journal'] = [
            'title' => get_string($this->searchTree, 'MedlineCitation.Article.Journal.Title'),
            'issn' => $this->getIssns(),
        ];
    }

    /**
     * Extract and format data needed for the Authors Relationship
     * on the Publication Model.
     */
    public function extractAuthorsData(): void
    {
        try {
            $this->loopOverAuthors();
        } catch (\Exception $e) {
            // Empty catch block, don't want anything to happen in case of exception.
        }
    }

    public function extractUpdatesData(): void
    {
        try {
            foreach ($this->searchTree->MedlineCitation->CommentsCorrectionsList->CommentsCorrections as $correction) {
                $this->getUpdateFromCorrection($correction);
            }
        } catch (\Exception $e) {
            // Don't stop in case of unreadable date format
        }
    }

    /**
     * @param $correction
     */
    protected function getUpdateFromCorrection($correction): void
    {
        if (in_array(stringify($correction['RefType']), array_keys(UpdateTypesStandardiser::TYPES_MAP))) {
            $this->resourceOutput['updates'][] = [
                'timestamp' => $this->getUpdateTimestamp(stringify($correction->RefSource)),
                'identifier' => [
                    'pubmed' => get_string($correction, 'PMID'),
                ],
                'type' => UpdateTypesStandardiser::getType(stringify($correction['RefType'])),
            ];
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

    /**
     * Loop over authors array.
     */
    protected function loopOverAuthors(): void
    {
        foreach ($this->searchTree->MedlineCitation->Article->AuthorList->Author as $author) {
            $this->createAuthorEntry($author);
        }
    }

    /**
     * Create an author entry in output.
     *
     * @param $author
     */
    protected function createAuthorEntry($author): void
    {
        if (! empty($lastName = get_string($author, 'LastName'))) {
            $affiliations = $this->loopOverAffiliations($author);

            $this->resourceOutput['authors'][] = [
                'first_name' => get_string($author, 'ForeName'),
                'last_name' => $lastName,
                'email' => $this->getEmailsFromAffiliations($affiliations),
                'affiliation' => $affiliations,
            ];
        }
    }

    /**
     * Loop over affiliations.
     *
     * @param  array  $author
     * @return array
     */
    protected function loopOverAffiliations($author): array
    {
        $affiliations = [];
        foreach ($author->AffiliationInfo as $affiliation) {
            $affiliations[]['name'] = get_string($affiliation, 'Affiliation');
        }

        return $affiliations;
    }

    /**
     * Get emails from affiliations array.
     *
     * @param  array  $affiliations
     * @return string
     */
    protected function getEmailsFromAffiliations($affiliations): string
    {
        return get_string(find_emails_in_array(Arr::pluck($affiliations, 'name')), 0);
    }

    protected function getUpdateTimestamp($refSource)
    {
        preg_match('/\s(\d{4}\s\w{3}(\s\d{1,2})?);/', $refSource, $matches);

        return date_from_human_readable($matches[1])->timestamp;
    }
}
