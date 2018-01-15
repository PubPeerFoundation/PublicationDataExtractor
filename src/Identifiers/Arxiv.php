<?php

namespace XavRsl\PublicationDataExtractor\Identifiers;

class Arxiv extends Identifier
{
    protected $resources = [
        'arxiv' => \XavRsl\PublicationDataExtractor\Resources\Arxiv::class,
    ];

    protected $regex = '/\d{2}(0|1)[0-9]\.\d{4,5}(v|V)?(\d)?/';

    protected $baseUrl = 'https://arxiv.org/abs/';

    public function getQueryString()
    {
        return rtrim($this->matches[0], ' .');
    }
}