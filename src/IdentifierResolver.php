<?php

namespace PubPeerFoundation\PublicationDataExtractor;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnknownIdentifierException;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class IdentifierResolver
{
    /**
     * List of available Identifiers.
     *
     * @var array
     */
    protected $identifiers = [
        Identifiers\BioRxiv::class,
        Identifiers\Figshare::class,
        Identifiers\Doi::class,
        Identifiers\Arxiv::class,
        Identifiers\Pubmed::class,
    ];

    /**
     * The query string.
     *
     * @var string
     */
    private $queryString;

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
     * @throws UnknownIdentifierException
     * @return Identifiers\Identifier
     */
    public function handle(): Identifier
    {
        foreach ($this->identifiers as $identifierClass) {
            $identifier = new $identifierClass($this->queryString);

            if ($identifier->isValid()) {
                return $identifier;
            }
        }

        throw new UnknownIdentifierException();
    }
}
