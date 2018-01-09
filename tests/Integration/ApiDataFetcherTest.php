<?php

namespace XavRsl\PublicationDataExtractor\Test\Integration;

use XavRsl\PublicationDataExtractor\ApiDataFetcher;
use XavRsl\PublicationDataExtractor\Identifier;
use XavRsl\PublicationDataExtractor\Test\TestCase;

class ApiDataFetcherTest extends TestCase
{
    /** @test */
    public function it_fetches_data()
    {
        // Arrange
        $identifier = new Identifier('10.1152/jn.00446.2010');
        $dataFetcher = new ApiDataFetcher($identifier->resolve());

        // Act
        $dataFetcher->getData();

        // Assert
        $this->assertCount(2, $dataFetcher->apiData);
    }
}
