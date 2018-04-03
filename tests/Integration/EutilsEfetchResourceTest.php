<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Resources\EutilsEfetch;

class EutilsEfetchResourceTest extends TestCase
{
    /** @test */
    public function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = (new IdentifierResolver('146534'))->handle();

        // Act
        $result = (new EutilsEfetch($identifier))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}
