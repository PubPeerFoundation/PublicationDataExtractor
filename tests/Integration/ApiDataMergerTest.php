<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\ApiDataMerger;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\ApiDataFetcher;

class ApiDataMergerTest extends TestCase
{
    /** @test */
    public function it_merges_data_from_fetcher()
    {
        // Arrange
        $fetchedData = [
            ['publication' => ['title' => 'blabla']],
            ['publication' => ['title' => 'blibli']],
        ];

        // Act
        $mergedData = ApiDataMerger::handle($fetchedData);

        // Assert
        $this->assertCount(1, $mergedData);
        $this->assertArrayHasKey('publication', $mergedData);
        $this->assertCount(2, $mergedData['publication']);
    }
}
