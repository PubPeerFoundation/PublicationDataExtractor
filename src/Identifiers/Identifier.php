<?php

namespace PubPeerFoundation\PublicationDataExtractor\Identifiers;

abstract class Identifier
{
    /**
     * The query string.
     *
     * @var string
     */
    private $queryString;

    /**
     * The regex matches.
     *
     * @var array
     */
    protected $matches;

    /**
     * The regex to identify an identifier.
     *
     * @var string
     */
    protected $regex;

    /**
     * Array containing API resources to be fetched.
     *
     * @var array
     */
    protected $resources;

    /**
     * Base resource webpage URL.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Identifier constructor.
     *
     * @param string $queryString
     */
    public function __construct(string $queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * Does the query contain a valid Identifier?
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return (bool) preg_match($this->regex, $this->queryString, $this->matches);
    }

    /**
     * Resources getter.
     *
     * @return array
     */
    public function getRelatedResources(): array
    {
        return $this->resources;
    }

    /**
     * Return URL to the identifier's publication website.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->baseUrl.$this->getQueryString();
    }

    /**
     * Class to String.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->getQueryString();
    }

    /**
     * QueryString getter.
     *
     * @return string
     */
    public function getQueryString()
    {
        return rtrim($this->queryString, ' .');
    }
}
