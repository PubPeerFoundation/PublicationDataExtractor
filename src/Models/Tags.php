<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Tags extends Model
{
    /**
     * Hold cherry picked list of tags.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown tags to the current list.
     */
    public function add(array $tags): array
    {
        foreach ($tags as $tag) {
            if (! in_array(strtolower($tag['name']), $this->knownIdentifierValues('name'))) {
                $this->list[] = $tag;
            }
        }

        return $this->list;
    }
}
