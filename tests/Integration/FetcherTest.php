<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Fetcher;
use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class FetcherTest extends TestCase
{
    /**
     * @test
     *
     * @group internet
     */
    public function it_fetches_data_from_a_doi_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('29358649');
        $dataFetcher = new Fetcher($identifier->handle());

        // Act
        $output = $dataFetcher->fetch();

        // Assert
        $this->assertArrayIsValid($output->getData());
    }

    /**
     * @test
     *
     * @group internet
     */
    public function it_fetches_data_from_a_pubmed_doi_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1038/s41591-018-0049-z');
        $dataFetcher = new Fetcher($identifier->handle());

        // Act
        $output = $dataFetcher->fetch();

        // Assert
        $this->assertArrayIsValid($output->getData());
    }

    /**
     * @test
     *
     * @group internet
     */
    public function it_fetches_data_from_a_arxiv_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('1708.03486');
        $dataFetcher = new Fetcher($identifier->handle());

        // Act
        $output = $dataFetcher->fetch();

        // Assert
        $this->assertArrayIsValid($output->getData());
    }

    /**
     * @test
     *
     * @group internet
     */
    public function it_fetches_data_from_a_pubmed_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('13054692');
        $dataFetcher = new Fetcher($identifier->handle());

        // Act
        $output = $dataFetcher->fetch();

        // Assert
        $this->assertArrayIsValid($output->getData());
    }

    /**
     * @test
     *
     * @group internet
     */
    public function it_fetches_data_from_a_doi_book_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.4337/9781783475360');
        $dataFetcher = new Fetcher($identifier->handle());

        // Act
        $output = $dataFetcher->fetch();

        // Assert
        $this->assertArrayIsValid($output->getData());
    }

    /**
     * @test
     *
     * @group internet
     */
    public function it_lists_errors_from_rejected_api_calls()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1023/B');
        $dataFetcher = new Fetcher($identifier->handle());

        // Act
        $output = $dataFetcher->fetch();
        $errors = $dataFetcher->getErrors();

        // Assert
        $this->assertEmpty($output->getData());
        $this->assertArraySubset(['Doi' => 404, 'Crossref' => 404], $errors);
    }

    /** @test */
    public function it_can_extract_pubmed_ids_from_id_converter()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1371/journal.pone.0009996');
        $dataFetcher = new Fetcher($identifier->handle());

        // Act
        $output = $dataFetcher->fetch();

        // Assert
        $extracted = $output->getData();

        $this->assertCount(1, array_filter($extracted['identifiers'], function ($identifier) {
            return 'pubmed' === $identifier['type'];
        }));
    }

    /** @test */
    public function it_can_extract_updates_from_crossref_updates()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1038/s41588-017-0029-0');
        $dataFetcher = new Fetcher($identifier->handle());

        // Act
        $output = $dataFetcher->fetch();

        // Assert
        $extracted = $output->getData();

        $this->assertGreaterThan(0, $extracted['updates']);
    }
}
