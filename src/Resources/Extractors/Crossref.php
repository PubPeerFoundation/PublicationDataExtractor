<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Support\UpdateTypesStandardiser;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\JournalTitleNotFoundException;

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
        try {
            $this->extractJournalData();
        } catch (JournalTitleNotFoundException $e) {
            $this->searchTree['container-title'] = $this->searchTree['publisher'];
        }
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
            'title' => get_string($this->searchTree, 'title'),
            'abstract' => get_string($this->searchTree, 'abstract'),
            'url' => $this->searchTree['URL'] ?? null,
            'published_at' => $date,
        ];
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

        foreach (get_array($this->searchTree, 'ISSN') as $issn) {
            $this->output['identifiers'][] = [
                'value' => $issn,
                'type' => 'issn',
            ];
        }
    }

    /**
     * Extract and format data needed for the Journal Relationship
     * on the Publication Model.
     *
     * @throws JournalTitleNotFoundException
     */
    public function extractJournalData()
    {
        if (empty($this->searchTree['container-title']) && empty($this->searchTree['ISSN'])) {
            throw new JournalTitleNotFoundException();
        }

        $this->output['journal'] = [
            'title' => get_string($this->searchTree, 'container-title'),
            'issn' => get_array($this->searchTree, 'ISSN'),
            'publisher' => get_string($this->searchTree, 'publisher'),
        ];
    }

    /**
     * Extract and format data needed for the Authors Relationship
     * on the Publication Model.
     */
    public function extractAuthorsData()
    {
        foreach (get_array($this->searchTree, 'author') as $author) {
            if (isset($author['family'])) {
                $this->output['authors'][] = [
                    'first_name' => get_string($author, 'given'),
                    'last_name' => get_string($author, 'family'),
                    'orcid' => get_string($author, 'ORCID'),
                    'affiliation' => get_array($author, 'affiliation'),
                ];
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
            'name' => get_string($this->searchTree, 'type'),
        ];
    }

    /**
     * Extract and format data needed for the tags Relationship
     * on the Publication Model.
     */
    public function extractTagsData()
    {
        foreach (get_array($this->searchTree, 'subject') as $tag) {
            $this->output['tags'][] = [
                'name' => $tag,
            ];
        }
    }

    protected function extractDateFrom($array)
    {
        $datePartsContainer = array_values(array_filter($array, function ($string) {
            return isset($this->searchTree[$string]);
        }))[0];

        return date_from_parts($this->searchTree[$datePartsContainer]['date-parts'][0]);
    }

    public function extractUpdatesData()
    {
        foreach (get_array($this->searchTree, 'update-to') as $update) {
            $this->output['updates'][] = [
                'timestamp' => $update['updated']['timestamp'],
                'identifier' => [
                    'doi' => get_string($update, 'DOI'),
                ],
                'type' => UpdateTypesStandardiser::getType($update['type']),
            ];
        }
    }
}
