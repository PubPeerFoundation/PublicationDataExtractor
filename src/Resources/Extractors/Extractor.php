<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use PubPeerFoundation\PublicationDataExtractor\Models\Output;
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

        foreach (ApiDataChecker::getDataTypes() as $type) {
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
//        if (isset($this->output['identifiers'])) {
//            Output::getInstance()->addIdentifiers($this->output['identifiers']);
//        }
//        if (isset($this->output['publication'])) {
//            Output::getInstance()->addPublication($this->output['publication']);
//        }
//        if (isset($this->output['journal'])) {
//            Output::getInstance()->addJournal($this->output['journal']);
//        }
//        if (isset($this->output['affiliations'])) {
//            Output::getInstance()->addAffiliations($this->output['affiliations']);
//        }
//        if (isset($this->output['types'])) {
//            Output::getInstance()->addTypes($this->output['types']);
//        }
//        if (isset($this->output['tags'])) {
//            Output::getInstance()->addTags($this->output['tags']);
//        }
//        if (isset($this->output['authors'])) {
//            Output::getInstance()->addAuthors($this->output['authors']);
//        }
        foreach (ApiDataChecker::getDataTypes() as $type) {
            if (isset($this->output[$type])) {
                $method = 'add'.ucfirst($type);
                Output::getInstance()->$method($this->output[$type]);
            }
        }

        $this->addOutputSource();

        return $this->output;
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
