<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

class Arxiv extends Identifier
{
    /**
     * @var array
     */
    protected $resources = [
        \PubPeerFoundation\PublicationDataExtractor\Resources\Arxiv::class,
    ];

    /**
     * @var string
     */
    protected $regex = '/\d{2}(0|1)[0-9]\.\d{4,5}(v|V)?(\d)?/';

    /**
     * @var string
     */
    protected $baseUrl = 'https://arxiv.org/abs/';

    /**
     * Get the query string.
     *
     * @return string
     */
    public function getQueryString()
    {
        return rtrim($this->matches[0], ' .');
    }
}
