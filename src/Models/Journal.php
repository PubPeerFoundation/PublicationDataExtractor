<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Journal extends Model
{
    /**
     * Hold the journal details.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown attributes to the current details array.
     *
     * @param  array $journal
     * @return array
     */
    public function add(array $journal): array
    {
        foreach ($journal as $key => $value) {
            if ($this->shouldKeepAttribute($key, $value)) {
                $this->list[$key] = $value;
            }
        }

        return $this->list;
    }
}
