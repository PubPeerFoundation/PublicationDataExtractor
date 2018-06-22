<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Resources\IdConverter;

class IdConverterResourceTest extends TestCase
{
    /** @test */
    public function it_returns_empty_array_if_status_is_not_ok()
    {
        // Arrange
        $identifier = (new IdentifierResolver('10.123/4567'))->handle();

        // Act
        $result = (new IdConverter($identifier, new Output()))->getDataFrom('{"status":"not-ok"}');

        // Assert
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = (new IdentifierResolver('10.123/4567'))->handle();

        // Act
        $result = (new IdConverter($identifier, new Output()))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}
