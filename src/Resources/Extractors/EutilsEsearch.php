<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class EutilsEsearch extends Extractor implements ProvidesIdentifiersData
{
    /**
     * Extract search tree from document.
     *
     * @throws UnparseableApiException
     */
    protected function fillSearchTree(): void
    {
        if ($this->document['esearchresult']['count'] !== '1') {
            throw new UnparseableApiException();
        }

        $this->searchTree = $this->document['esearchresult'];
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData(): void
    {
        foreach ($this->searchTree['idlist'] as $identifier) {
            $this->resourceOutput['identifiers'][] = [
                'value' => stringify($identifier),
                'type' => 'pubmed',
            ];
        }
    }
}
