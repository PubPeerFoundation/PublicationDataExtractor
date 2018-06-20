<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\ApiDataChecker;
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
     * @var array
     */
    protected $output = [];

    /**
     * Extractor constructor.
     *
     * @param $document
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * Dynamically choose what methods to call on each Resource.
     *
     * @return array
     */
    public function extract(): array
    {
        $this->getDataFromDocument();

        foreach ($this->dataTypes() as $type) {
            $class = __NAMESPACE__.'\\Provides'.ucfirst($type).'Data';

            if ($this instanceof $class) {
                $method = 'extract'.ucfirst($type).'Data';
                try {
                    $this->$method();
                } catch (JournalTitleNotFoundException $e) {
                    $this->output['journal']['title'] = $this->output['journal']['publisher'];
                }
            }
        }

        $this->addOutputSource();

        return $this->output;
    }

    /**
     * Get a list of data Types from Schema.
     *
     * @return array
     */
    protected function dataTypes(): array
    {
        return array_slice(array_keys(ApiDataChecker::SCHEMA['root']), 1);
    }

    /**
     * Prepare each data document.
     *
     * @return mixed
     */
    abstract protected function getDataFromDocument();

    /**
     *  Set the source of the data on the data.
     */
    protected function addOutputSource(): void
    {
        if (! empty($this->output)) {
            $this->output['_source'] = get_class_name($this);
        }
    }
}
