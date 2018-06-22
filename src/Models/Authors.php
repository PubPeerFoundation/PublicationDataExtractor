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
     * @param  array $authors
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

    /**
     * Add unknown attributes to current author.
     *
     * @param array $authors
     * @param int   $counter
     */
    protected function addUnknownAttributes(array $authors, int $counter): void
    {
        foreach ($authors[$counter] as $key => $value) {
            if (empty($value)) {
                continue;
            }
            if (isset($this->list[$counter][$key]) && ! empty($this->list[$counter][$key])) {
                $this->list[$counter][$key] = $value;
            }
        }
    }
}
