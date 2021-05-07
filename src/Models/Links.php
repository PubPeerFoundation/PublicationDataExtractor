<?php

namespace PubPeerFoundation\PublicationDataExtractor\Models;

class Links extends Model
{
    /**
     * Hold cherry picked list of links.
     *
     * @var array
     */
    protected $list = [];

    /**
     * Add unknown links to the current list.
     */
    public function add(array $links): array
    {
        foreach ($links as $link) {
            if ($this->hasPreprint($link)) {
                $this->list[] = $link;
            }
            if ($this->isPreprint($link)) {
                $this->list[] = $link;
            }
        }

        return $this->list;
    }

    private function hasPreprint(array $link): bool
    {
        if (! array_key_exists('has_preprint', $link)) {
            return false;
        }

        return ! in_array(strtolower($link['has_preprint']), $this->knownIdentifierValues('has_preprint'));
    }

    private function isPreprint(array $link): bool
    {
        if (! array_key_exists('is_preprint_of', $link)) {
            return false;
        }

        return ! in_array(strtolower($link['is_preprint_of']), $this->knownIdentifierValues('is_preprint_of'));
    }
}
