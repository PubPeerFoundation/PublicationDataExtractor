<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Resources\Arxiv;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;

class ArxivResourceTest extends TestCase
{
    /** @test */
    public function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = new Identifier('1708.03486v2');

        // Act
        $result = (new Arxiv($identifier))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}
