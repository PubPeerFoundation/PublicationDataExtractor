<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Schema;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\JournalTitleNotFoundException;

abstract class Extractor
{
    /**
     * @var mixed
     */
    protected $document;

    /**
     * @var array
     */
    protected $searchTree;

    /**
     * Temporary Resource output array.
     *
     * @var array
     */
    protected $resourceOutput = [];

    /**
     * Global Output object.
     *
     * @var Output
     */
    protected $output;

    /**
     * Extractor constructor.
     *
     * @param mixed  $document
     * @param Output $output
     */
    public function __construct($document, Output $output)
    {
        $this->document = $document;
        $this->output = $output;
    }

    /**
     * Dynamically choose what methods to call on each Resource.
     *
     * @return array
     */
    public function extract(): array
    {
        try {
            $this->fillSearchTree();

            foreach (Schema::getDataTypes() as $type) {
                $this->extractData($type);

                $this->buildOutput($type);
            }

            $this->addOutputSource();

            return $this->resourceOutput;
        } catch (UnparseableApiException $e) {
            return [];
        }
    }

    /**
     * Prepare each data document.
     *
     * @throws UnparseableApiException
     */
    abstract protected function fillSearchTree(): void;

    /**
     *  Set the source of the data on the data.
     */
    protected function addOutputSource(): void
    {
        if (! empty($this->output)) {
            $this->resourceOutput['_source'] = get_class_name($this);
        }
    }

    /**
     * Extract data from each type of the Resource.
     *
     * @param $type
     */
    protected function extractData($type): void
    {
        $class = __NAMESPACE__.'\\Provides'.ucfirst($type).'Data';

        if ($this instanceof $class) {
            $method = 'extract'.ucfirst($type).'Data';
            try {
                $this->$method();
            } catch (JournalTitleNotFoundException $e) {
                $this->resourceOutput['journal']['title'] = $this->resourceOutput['journal']['publisher'];
            }
        }
    }

    /**
     * Build data output for each Resource type.
     *
     * @param $type
     */
    protected function buildOutput($type): void
    {
        if (isset($this->resourceOutput[$type])) {
            $method = 'add'.ucfirst($type);
            $this->output->$method($this->resourceOutput[$type]);
        }
    }
}
