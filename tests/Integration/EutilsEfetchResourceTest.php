<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;
use PubPeerFoundation\PublicationDataExtractor\Resources\EutilsEfetch;

class EutilsEfetchResourceTest extends TestCase
{
    /** @test */
    public function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = new Identifier('146534');

        // Act
        $result = (new EutilsEfetch($identifier))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}
