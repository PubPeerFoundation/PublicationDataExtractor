<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\ApiDataFetcher;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

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
