<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class IdConverter implements Extractor, ProvidesIdentifiersData
{
    protected $document;

    protected $searchTree;

    protected $typeMap = [
        'pmcid' => 'pmc',
        'pmid' => 'pubmed',
        'doi' => 'doi',
    ];

    protected $output;

    public function __construct($document)
    {
        $this->document = $document;
    }

    public function extract(): array
    {
        $this->getDataFromDocument();
        $this->extractIdentifiersData();

        return $this->output;
    }

    protected function getDataFromDocument()
    {
        if ('ok' !== $this->document['status']) {
            throw new UnparseableApiException();
        }

        $this->searchTree = $this->document['records'][0];
    }

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
