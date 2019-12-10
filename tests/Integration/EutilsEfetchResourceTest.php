<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Resources\EutilsEfetch;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class EutilsEfetchResourceTest extends TestCase
{
    /** @test */
    public function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = (new IdentifierResolver('146534'))->handle();

        // Act
        $result = (new EutilsEfetch($identifier, new Output()))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}
