<?php

namespace XavRsl\PublicationDataExtractor\Test\Integration;

use XavRsl\PublicationDataExtractor\Identifiers\Identifier;
use XavRsl\PublicationDataExtractor\Resources\Crossref;
use XavRsl\PublicationDataExtractor\Test\TestCase;

class CrossrefResourceTest extends TestCase
{
    /** @test */
    function it_returns_empty_array_if_status_is_not_ok()
    {
        // Arrange
        $identifier = new Identifier('10.123/4567');

        // Act
        $result = (new Crossref($identifier))->getDataFrom('{"status":"not-ok"}');

        // Assert
        $this->assertEmpty($result);
    }

    /** @test */
    function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = new Identifier('10.123/4567');

        // Act
        $result = (new Crossref($identifier))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}