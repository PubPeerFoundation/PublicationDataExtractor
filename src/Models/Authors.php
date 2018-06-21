<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Authors extends Model
{
    /**
     * Hold cherry picked list of authors.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown authors to the current list.
     *
     * @param $authors
     * @return array
     */
    public function add(array $authors): array
    {
        if (($count = count($authors)) !== ($listCount = count($this->list))) {
            if ($count > $listCount) {
                return $this->list = $authors;
            }

            return $this->list;
        }

        for ($i = 0; $i < $count; ++$i) {
            $this->addUnknownAttributes($authors, $i);
        }

        return $this->list;
    }

    protected function addUnknownAttributes($authors, $i)
    {
        foreach ($authors[$i] as $key => $value) {
            if (empty($value)) {
                continue;
            }
            if (isset($this->list[$i][$key]) && ! empty($this->list[$i][$key])) {
                $this->list[$i][$key] = $value;
            }
        }
    }
}
