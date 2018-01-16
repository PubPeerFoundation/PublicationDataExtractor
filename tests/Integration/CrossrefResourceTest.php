<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Resources\Crossref;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\IdentifierResolver;

class CrossrefResourceTest extends TestCase
{
    /** @test */
    public function it_returns_empty_array_if_status_is_not_ok()
    {
        // Arrange
        $identifier = (new IdentifierResolver('10.123/4567'))->handle();

        // Act
        $result = (new Crossref($identifier))->getDataFrom('{"status":"not-ok"}');

        // Assert
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = (new IdentifierResolver('10.123/4567'))->handle();

        // Act
        $result = (new Crossref($identifier))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}
