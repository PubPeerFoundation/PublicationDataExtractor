<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Helpers\DateHelper;
use PubPeerFoundation\PublicationDataExtractor\Helpers\UpdateTypesStandardiser;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class Crossref implements Extractor, ProvidesPublicationData, ProvidesIdentifiersData, ProvidesJournalData, ProvidesAuthorsData, ProvidesUpdatesData
{
    protected $document;

    protected $searchTree;

    protected $output = [];

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
        $this->extractTagsData();
        $this->extractTypesData();
        $this->extractUpdatesData();

        return $this->output;
    }

    protected function getDataFromDocument()
    {
        if ('ok' !== $this->document['status']) {
            throw new UnparseableApiException();
        }

        $this->searchTree = $this->document['message'];
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData()
    {
        $date = $this->extractDateFrom(['published-print', 'published-online', 'issued']);

        $this->output['publication'] = [
            'title' => $this->extractTitle() ?? null,
            'abstract' => $this->searchTree['abstract'] ?? null,
            'url' => $this->searchTree['URL'] ?? null,
            'published_at' => $date,
        ];
    }

    /**
     * @return mixed
     */
    protected function extractTitle()
    {
        return is_array($this->searchTree['title']) ? $this->searchTree['title'][0] : $this->searchTree['title'];
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData()
    {
        if (! empty($this->searchTree['DOI'])) {
            $this->output['identifiers'][] = [
                'value' => $this->searchTree['DOI'],
                'type' => 'doi',
            ];
        }

        if (! empty($this->searchTree['ISSN'])) {
            if (is_array($this->searchTree['ISSN'])) {
                foreach ($this->searchTree['ISSN'] as $issn) {
                    $this->output['identifiers'][] = [
                        'value' => $issn,
                        'type' => 'issn',
                    ];
                }
            } else {
                $this->output['identifiers'][] = [
                    'value' => $this->searchTree['ISSN'],
                    'type' => 'issn',
                ];
            }
        }
    }

    /**
     * Extract and format data needed for the Journal Relationship
     * on the Publication Model.
     */
    public function extractJournalData()
    {
        if (array_key_exists('ISSN', $this->searchTree) && ! is_array($this->searchTree['ISSN'])) {
            $this->searchTree['ISSN'] = [$this->searchTree['ISSN']];
        }

        $this->output['journal'] = [
            'title' => $this->searchTree['container-title'] ?? null,
            'issn' => $this->searchTree['ISSN'] ?? null,
            'publisher' => $this->searchTree['publisher'] ?? null,
        ];
    }

    /**
     * Extract and format data needed for the Authors Relationship
     * on the Publication Model.
     */
    public function extractAuthorsData()
    {
        if (array_key_exists('author', $this->searchTree)) {
            foreach ($this->searchTree['author'] as $author) {
                if (isset($author['family'])) {
                    $this->output['authors'][] = [
                        'first_name' => $author['given'] ?? null,
                        'last_name' => $author['family'] ?? null,
                        'orcid' => $author['ORCID'] ?? null,
                        'affiliation' => $author['affiliation'] ?? null,
                    ];
                }
            }
        }
    }

    /**
     * Extract and format data needed for the Types Relationship
     * on the Publication Model.
     */
    public function extractTypesData()
    {
        $this->output['types'][] = [
            'name' => $this->searchTree['type'] ?? null,
        ];
    }

    /**
     * Extract and format data needed for the tags Relationship
     * on the Publication Model.
     */
    public function extractTagsData()
    {
        if (array_key_exists('subject', $this->searchTree)) {
            foreach ($this->searchTree['subject'] as $tag) {
                $this->output['tags'][] = [
                    'name' => $tag,
                ];
            }
        }
    }

    protected function extractDateFrom($array)
    {
        $datePartsContainer = array_filter($array, function ($string) {
            return isset($this->searchTree[$string]);
        })[0];

        return (new DateHelper())
            ->dateFromDateParts($this->searchTree[$datePartsContainer]['date-parts'][0]);
    }

    public function extractUpdatesData()
    {
        if (array_key_exists('update-to', $this->searchTree)) {
            foreach ($this->searchTree['update-to'] as $update) {
                $this->output['updates'][] = [
                    'timestamp' => $update['updated']['timestamp'],
                    'identifier' => [
                        'doi' => $update['DOI'],
                    ],
                    'type' => UpdateTypesStandardiser::getType($update['type']),
                ];
            }
        }
    }
}
