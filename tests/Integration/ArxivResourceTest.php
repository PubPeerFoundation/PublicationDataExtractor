<?php

namespace XavRsl\PublicationDataExtractor\Test\Integration;

use XavRsl\PublicationDataExtractor\Identifiers\Identifier;
use XavRsl\PublicationDataExtractor\Resources\Arxiv;
use XavRsl\PublicationDataExtractor\Test\TestCase;

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
