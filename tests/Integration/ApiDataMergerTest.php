<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\ApiDataMerger;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\ApiDataFetcher;

class ApiDataMergerTest extends TestCase
{
    /** @test */
    public function it_fetches_data_from_a_doi_identifier()
    {
        // Arrange
        $dataFetcher = $this->getMockBuilder(ApiDataFetcher::class)
            ->disableOriginalConstructor()
            ->getMock();

        $dataFetcher->apiData = [
            ['publication' => ['title' => 'blabla']],
            ['publication' => ['title' => 'blibli']],
        ];

        $dataFetcher->getData();

        // Act
        $mergedData = ApiDataMerger::handle($dataFetcher);

        // Assert
        $this->assertCount(1, $mergedData);
        $this->assertArrayHasKey('publication', $mergedData);
    }
}
