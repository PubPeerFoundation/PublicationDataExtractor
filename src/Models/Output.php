<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

use PubPeerFoundation\PublicationDataExtractor\ApiDataChecker;

class Output extends Model
{
    /**
     * Global content array.
     *
     * @var array
     */
    protected $content = [];

    /**
     * Dynamically call the add method on the desired model.
     *
     * @param string $name
     * @param array  $resourceData
     */
    public function __call($name, array $resourceData): void
    {
        $name = strtolower(substr($name, 3));

        if (in_array($name, ApiDataChecker::getDataTypes())) {
            $className = __NAMESPACE__.'\\'.ucfirst($name);
            $this->content[$name] = $className::getInstance()->add($resourceData[0]);
        }
    }

    /**
     * Output the formatted content array.
     *
     * @return array
     */
    public function format()
    {
        $this->resetLists();

        return $this->content;
    }

    protected function resetLists()
    {
        foreach (ApiDataChecker::getDataTypes() as $type) {
            $className = __NAMESPACE__.'\\'.ucfirst($type);
            $className::getInstance()->reset();
        }
    }
}
