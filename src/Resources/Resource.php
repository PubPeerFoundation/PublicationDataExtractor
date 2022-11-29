<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;
use PubPeerFoundation\PublicationDataExtractor\Output;

abstract class Resource
{
    /**
     * @var Output
     */
    protected $output;

    /**
     * @var Identifier
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $url;

    /**
     * Resource constructor.
     *
     * @param  Identifier  $identifier
     * @param  Output  $output
     */
    public function __construct(Identifier $identifier, Output $output)
    {
        $this->identifier = $identifier;
        $this->output = $output;
    }

    /**
     * Full URL to the fetched resource.
     *
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->url;
    }

    /**
     * Request Options Array used to fetch the resource.
     *
     * @return array
     */
    abstract public function getRequestOptions(): array;

    /**
     * Transform raw data to a usable format.
     *
     * @param  string  $document
     * @return array
     */
    abstract public function getDataFrom(string $document): array;
}
