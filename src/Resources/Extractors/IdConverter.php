<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class IdConverter extends Extractor implements ProvidesIdentifiersData
{
    /**
     * @var array
     */
    protected $typeMap = [
        'pmcid' => 'pmc',
        'pmid' => 'pubmed',
        'doi' => 'doi',
    ];

    /**
     * Extract search tree from document.
     *
     * @throws UnparseableApiException
     */
    protected function getDataFromDocument()
    {
        if ('ok' !== $this->document['status']) {
            throw new UnparseableApiException();
        }

        if (isset($this->document['records'][0]['status']) && 'error' === $this->document['records'][0]['status']) {
            throw new UnparseableApiException();
        }

        $this->searchTree = $this->document['records'][0];
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData()
    {
        foreach ($this->searchTree as $type => $identifier) {
            if (array_key_exists($type, $this->typeMap)) {
                $this->output['identifiers'][] = [
                    'value' => $identifier,
                    'type' => $this->typeMap[$type],
                ];
            }
        }
    }
}
