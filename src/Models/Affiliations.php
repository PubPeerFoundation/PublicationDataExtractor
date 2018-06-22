<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Affiliations extends Model
{
    /**
     * Hold cherry picked list of affiliations.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown affiliations to the current list.
     *
     * @param  array $affiliations
     * @return array
     */
    public function add(array $affiliations): array
    {
        foreach ($affiliations as $affiliation) {
            if (! in_array(strtolower($affiliation['name']), $this->knownIdentifierValues('name'))) {
                $this->list[] = $affiliation;
            }
        }

        return $this->list;
    }
}
