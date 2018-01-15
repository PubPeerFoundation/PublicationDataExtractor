<?php

namespace XavRsl\PublicationDataExtractor\Test\Integration;

use XavRsl\PublicationDataExtractor\Identifiers\Identifier;
use XavRsl\PublicationDataExtractor\Resources\EutilsEfetch;
use XavRsl\PublicationDataExtractor\Test\TestCase;

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
