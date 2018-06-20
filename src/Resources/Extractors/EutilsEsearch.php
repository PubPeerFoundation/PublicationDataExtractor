<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class EutilsEsearch implements Extractor, ProvidesIdentifiersData
{
    /**
     * @var
     */
    protected $document;

    /**
     * @var
     */
    protected $searchTree;

    /**
     * @var
     */
    protected $output;

    /**
     * EutilsEsearch constructor.
     *
     * @param $document
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * @throws UnparseableApiException
     * @return array
     */
    public function extract(): array
    {
        $this->getDataFromDocument();
        $this->extractIdentifiersData();

        return $this->output;
    }

    /**
     * Extract search tree from document.
     *
     * @throws UnparseableApiException
     */
    protected function getDataFromDocument()
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
    public function extractIdentifiersData()
    {
        foreach ($this->searchTree['idlist'] as $identifier) {
            $this->output['identifiers'][] = [
                'value' => stringify($identifier),
                'type' => 'pubmed',
            ];
        }
    }
}
