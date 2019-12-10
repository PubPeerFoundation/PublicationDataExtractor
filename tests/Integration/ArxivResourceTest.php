<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Resources\Arxiv;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class ArxivResourceTest extends TestCase
{
    /** @test */
    public function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = (new IdentifierResolver('1708.03486v2'))->handle();

        // Act
        $result = (new Arxiv($identifier, new Output()))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}
