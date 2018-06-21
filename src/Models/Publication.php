<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Publication extends Model
{
    /**
     * Hold the publication details.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown attributes to the current details array.
     *
     * @param $publication
     * @return array
     */
    public function add(array $publication): array
    {
        foreach ($publication as $key => $value) {
            if ($this->shouldKeepAttribute($key, $value)) {
                $this->list[$key] = $value;
            }
        }

        return $this->list;
    }
}
