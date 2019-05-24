<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

class Arxiv extends Extractor implements ProvidesPublicationData, ProvidesIdentifiersData, ProvidesAuthorsData, ProvidesJournalData, ProvidesTypesData
{
    /**
     * Create search tree.
     */
    protected function fillSearchTree(): void
    {
        $this->searchTree = $this->document->entry;
    }

    /**
     * Extract and format data needed for the Publication Model.
     */
    public function extractPublicationData(): void
    {
        $this->resourceOutput['publication'] = [
            'title' => get_string($this->searchTree, 'title'),
            'abstract' => get_string($this->searchTree, 'summary'),
            'url' => get_string($this->searchTree, 'id'),
            'published_at' => date_from_parseable_format(get_string($this->searchTree, 'published')),
        ];
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData(): void
    {
        $this->resourceOutput['identifiers'][] = [
            'value' => (string) $this->getIdentifier(),
            'type' => 'arxiv',
        ];

        $this->resourceOutput['identifiers'][] = [
            'value' => '2331-8422',
            'type' => 'issn',
        ];

        $namespace = $this->searchTree->getNamespaces(true);
        foreach ($this->searchTree->children($namespace['arxiv']) as $key => $child) {
            if ('doi' === $key) {
                $this->resourceOutput['identifiers'][] = [
                    'value' => (string) $child,
                    'type' => 'doi',
                ];
            }
        }
    }

    /**
     * Extract and format data needed for the Journals Relationship
     * on the Publication Model.
     */
    public function extractJournalData(): void
    {
        $this->resourceOutput['journal'] = [
            'title' => 'arXiv',
            'issn' => ['2331-8422'],
        ];
    }

    /**
     * Extract and format data needed for the Authors Relationship
     * on the Publication Model.
     */
    public function extractAuthorsData(): void
    {
        foreach ($this->searchTree->author as $author) {
            $name = explode(' ', $author->name, 2);
            $this->resourceOutput['authors'][] = [
                'first_name' => $name[0] ?? null,
                'last_name' => $name[1] ?? null,
            ];
        }
    }

    /**
     * Extract and format data needed for the Types Relationship
     * on the Publication Model.
     */
    public function extractTypesData(): void
    {
        $this->resourceOutput['types'][] = [
            'name' => 'arxiv',
        ];
    }

    /**
     * Get the Identifier from the data.
     *
     * @return string
     */
    protected function getIdentifier(): string
    {
        preg_match('/(\d{2}(0|1)[0-9]\.\d{4,5})(v|V)?(\d)?/', $this->searchTree->id[0], $matches);

        return $matches[1];
    }
}
