<?php

namespace PubPeerFoundation\PublicationDataExtractor;

class Output
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
     * @param  string  $name
     * @param  array  $resourceData
     */
    public function __call(string $name, array $resourceData): void
    {
        $name = strtolower(substr($name, 3));

        if (in_array($name, Schema::getDataTypes())) {
            $className = __NAMESPACE__.'\\Models\\'.ucfirst($name);
            $this->content[$name] = $className::getInstance()->add($resourceData[0]);
        }
    }

    /**
     * Output the formatted content array.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->content;
    }

    /**
     * Reset each Model's list array.
     */
    public function resetLists(): void
    {
        foreach (Schema::getDataTypes() as $type) {
            $className = __NAMESPACE__.'\\Models\\'.ucfirst($type);
            $className::getInstance()->reset();
        }
    }
}
