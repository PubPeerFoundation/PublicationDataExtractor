<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Updates extends Model
{
    /**
     * Hold cherry picked list of types.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown updates to the current list.
     *
     * @param  array  $updates
     * @return array
     */
    public function add(array $updates): array
    {
        $this->list = $updates;

        return $this->list;
    }
}
