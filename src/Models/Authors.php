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

        for ($i = 0; $i < $count; $i++) {
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

            if ($this->attributeShouldBeAdded($counter, $key, $value)) {
                $this->list[$counter][$key] = $value;
            }
        }
    }

    /**
     * Should the current attribute be added to the author array?
     *
     * @param $counter
     * @param $key
     * @param $value
     * @return bool
     */
    protected function attributeShouldBeAdded($counter, $key, $value)
    {
        return $this->foundLongerFirstName($counter, $key, $value)
            || $this->noKnownAttribute($counter, $key);
    }

    /**
     * Is this attribute already known?
     *
     * @param $counter
     * @param $key
     * @return bool
     */
    protected function noKnownAttribute($counter, $key)
    {
        return ! isset($this->list[$counter][$key])
            || empty($this->list[$counter][$key]);
    }

    /**
     * Did we find a longer first name?
     *
     * @param $counter
     * @param $key
     * @param $value
     * @return bool
     */
    protected function foundLongerFirstName($counter, $key, $value)
    {
        return 'first_name' === $key
            && strlen($this->list[$counter][$key]) < strlen($value);
    }
}
