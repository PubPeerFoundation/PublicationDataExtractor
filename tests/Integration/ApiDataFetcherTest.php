<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\ApiDataFetcher;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\IdentifierResolver;

class ApiDataFetcherTest extends TestCase
{
    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_doi_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1152/jn.00446.2010');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->getData();

        // Assert
        $this->assertCount(2, $dataFetcher->apiData);
    }

    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_arxiv_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('1708.03486');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->getData();

        // Assert
        $this->assertCount(1, $dataFetcher->apiData);
    }

    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_pubmed_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('28658642');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->getData();

        // Assert
        $this->assertCount(1, $dataFetcher->apiData);
    }
}
