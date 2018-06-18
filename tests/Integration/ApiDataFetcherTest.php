<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\ApiDataMerger;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\ApiDataFetcher;
use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;

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
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(3, $dataFetcher->getData());
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
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(1, $dataFetcher->getData());
    }

    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_pubmed_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('13054692');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(1, $dataFetcher->getData());
    }

    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_doi_book_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.4337/9781783475360');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(2, $dataFetcher->getData());
    }

    /**
     * @test
     * @group internet
     */
    public function it_lists_errors_from_rejected_api_calls()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1023/B');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();
        $errors = $dataFetcher->getErrors();

        // Assert
        $this->assertEmpty($dataFetcher->getData());
        $this->assertArraySubset(['Doi' => 404, 'Crossref' => 404], $errors);
    }

    /** @test */
    public function it_can_extract_pubmed_ids_from_id_converter()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1371/journal.pone.0009996');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(3, $extracted = $dataFetcher->getData());

        $merged = ApiDataMerger::handle($extracted);
        $identifiers = array_merge(...$merged['identifiers']);
        $this->assertTrue(count(array_filter($identifiers, function($identifier) {
            return $identifier['type'] === 'pubmed';
        })) > 0);
    }
}
