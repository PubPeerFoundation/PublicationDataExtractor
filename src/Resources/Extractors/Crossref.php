<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\JournalTitleNotFoundException;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class Crossref extends Extractor implements ProvidesPublicationData, ProvidesIdentifiersData, ProvidesJournalData, ProvidesAuthorsData, ProvidesTagsData, ProvidesLinksData
{
    /**
     * @throws UnparseableApiException
     */
    protected function fillSearchTree(): void
    {
        if ('ok' !== $this->document['status']) {
            throw new UnparseableApiException();
        }

        $this->searchTree = $this->document['message'];
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData(): void
    {
        $date = $this->extractDateFrom(['published-print', 'published-online', 'issued']);

        $this->resourceOutput['publication'] = [
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
    public function extractIdentifiersData(): void
    {
        if (! empty($this->searchTree['DOI'])) {
            $this->resourceOutput['identifiers'][] = [
                'value' => $this->searchTree['DOI'],
                'type' => 'doi',
            ];
        }

        foreach (get_array($this->searchTree, 'ISSN') as $issn) {
            $this->resourceOutput['identifiers'][] = [
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
    public function extractJournalData(): void
    {
        $this->resourceOutput['journal'] = [
            'title' => get_string($this->searchTree, 'container-title'),
            'issn' => get_array($this->searchTree, 'ISSN'),
            'publisher' => get_string($this->searchTree, 'publisher'),
        ];

        if (empty($this->searchTree['container-title']) && empty($this->searchTree['ISSN'])) {
            throw new JournalTitleNotFoundException();
        }
    }

    /**
     * Extract and format data needed for the Authors Relationship
     * on the Publication Model.
     */
    public function extractAuthorsData(): void
    {
        foreach (get_array($this->searchTree, 'author') as $author) {
            if (isset($author['family'])) {
                $this->resourceOutput['authors'][] = [
                    'first_name' => get_string($author, 'given'),
                    'last_name' => get_string($author, 'family'),
                    'orcid' => get_string($author, 'ORCID'),
                    'sequence' => get_string($author, 'sequence'),
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
        $this->resourceOutput['types'][] = [
            'name' => get_string($this->searchTree, 'type'),
        ];
    }

    /**
     * Extract and format data needed for the tags Relationship
     * on the Publication Model.
     */
    public function extractTagsData(): void
    {
        foreach (get_array($this->searchTree, 'subject') as $tag) {
            $this->resourceOutput['tags'][] = [
                'name' => $tag,
            ];
        }
    }

    /**
     * Extract and format data needed for the links Relationship
     * on the Publication Model.
     */
    public function extractLinksData(): void
    {
        if (array_key_exists('relation', $this->searchTree)) {
            foreach (get_array($this->searchTree['relation'], 'has-preprint') as $preprint) {
                $this->resourceOutput['links'][] = [
                    'has_preprint' => $preprint['id'],
                ];
            }
            foreach (get_array($this->searchTree['relation'], 'is-preprint-of') as $preprint) {
                $this->resourceOutput['links'][] = [
                    'is_preprint_of' => $preprint['id'],
                ];
            }
        }
    }

    /**
     * @param $array
     * @return mixed
     */
    protected function extractDateFrom($array)
    {
        $datePartsContainer = array_values(array_filter($array, function ($string) {
            return isset($this->searchTree[$string]);
        }))[0];

        return date_from_parts($this->searchTree[$datePartsContainer]['date-parts'][0]);
    }
}
