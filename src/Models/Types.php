<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Types extends Model
{
    /**
     * Hold cherry picked list of types.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown types to the current list.
     *
     * @param $types
     * @return array
     */
    public function add(array $types): array
    {
        foreach ($types as $type) {
            if (! in_array(strtolower($type['name']), $this->knownIdentifierValues('name'))) {
                $this->list[] = $type;
            }
        }

        return $this->list;
    }
}
