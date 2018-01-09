<?php

namespace XavRsl\PublicationDataExtractor;

use XavRsl\PublicationDataExtractor\Exceptions\UnknownIdentifierException;

class Identifier
{
    /**
     * List of available Identifiers.
     *
     * @var array
     */
    protected $identifiers = [
        Identifiers\Doi::class, // 10.1152/jn.00446.2010
    ];

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
     * Identifier constructor.
     *
     * @param string $queryString
     */
    public function __construct(string $queryString)
    {
        $this->queryString = $queryString;
    }

    /**
     * Resolves the Identifier;.
     *
     * @return Identifier
     *
     * @throws UnknownIdentifierException
     */
    public function resolve()
    {
        foreach ($this->identifiers as $identifierClass) {
            $identifier = new $identifierClass($this->queryString);

            if ($identifier->isValid()) {
                return $identifier;
            }
        }

        throw new UnknownIdentifierException();
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
     * Array of resources setter.
     *
     * @param array $resources
     */
    public function setResources(array $resources)
    {
        $this->resources = $resources;
    }

    /**
     * QueryString getter.
     *
     * @return string
     */
    public function getQueryString(): string
    {
        return rtrim($this->queryString, ' .');
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
}
