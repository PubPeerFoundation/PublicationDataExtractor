<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Identifiers extends Model
{
    /**
     * Hold cherry picked list of identifiers.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown identifiers to the current list.
     *
     * @param  array $identifiers
     * @return array
     */
    public function add(array $identifiers): array
    {
        foreach ($identifiers as $identifier) {
            if (! in_array(strtolower($identifier['value']), $this->knownIdentifierValues('value'))) {
                $this->list[] = $identifier;
            }
        }

        return $this->list;
    }
}
