<?php

namespace XavRsl\PublicationDataExtractor\Test\Integration;

use XavRsl\PublicationDataExtractor\ApiDataFetcher;
use XavRsl\PublicationDataExtractor\Test\TestCase;
use XavRsl\PublicationDataExtractor\Identifiers\Identifier;

class ApiDataFetcherTest extends TestCase
{
    /** @test */
    public function it_fetches_data_from_a_doi_identifier()
    {
        // Arrange
        $identifier = new Identifier('10.1152/jn.00446.2010');
        $dataFetcher = new ApiDataFetcher($identifier->resolve());

        // Act
        $dataFetcher->getData();

        // Assert
        $this->assertCount(2, $dataFetcher->apiData);
    }

    /** @test */
    public function it_fetches_data_from_a_arxiv_identifier()
    {
        // Arrange
        $identifier = new Identifier('1708.03486');
        $dataFetcher = new ApiDataFetcher($identifier->resolve());

        // Act
        $dataFetcher->getData();

        // Assert
        $this->assertCount(1, $dataFetcher->apiData);
    }

    /** @test */
    public function it_fetches_data_from_a_pubmed_identifier()
    {
        // Arrange
        $identifier = new Identifier('28658642');
        $dataFetcher = new ApiDataFetcher($identifier->resolve());

        // Act
        $dataFetcher->getData();

        // Assert
        $this->assertCount(1, $dataFetcher->apiData);
    }
}
