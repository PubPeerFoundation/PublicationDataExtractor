<?php

namespace PubPeerFoundation\PublicationDataExtractor;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnknownIdentifierException;

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
     * @return Identifiers\Identifier
     *
     * @throws UnknownIdentifierException
     */
    public function handle()
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
