<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Resources\EutilsEsearch;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class EutilsEsearchResourceTest extends TestCase
{
    /** @test */
    public function it_extracts_the_pmid_when_pubmed_matched_the_whole_doi()
    {
        // Arrange
        $identifier = (new IdentifierResolver('10.3390/genes12010001'))->handle();

        $document = json_encode(['esearchresult' => [
            'count' => '1',
            'idlist' => ['33374967'],
            'querytranslation' => '"10 3390 genes12010001"[Publisher ID]',
        ]]);

        // Act
        $result = (new EutilsEsearch($identifier, new Output()))->getDataFrom($document);

        // Assert
        $this->assertEquals([
            ['value' => '33374967', 'type' => 'pubmed'],
        ], $result['identifiers']);
    }

    /**
     * When a DOI is absent from PubMed, esearch truncates the [Publisher ID]
     * phrase to its longest indexed prefix rather than returning zero hits.
     * Every unindexed 10.3390 DOI degrades to "10.3390"[Publisher ID], which
     * matches the single record whose PII is literally 10.3390 — so count is 1
     * and PMID 24710095 looks like a clean hit.
     *
     * @test
     */
    public function it_rejects_a_hit_pubmed_found_by_truncating_the_doi()
    {
        // Arrange
        $identifier = (new IdentifierResolver('10.3390/zzzz99999999'))->handle();

        $document = json_encode(['esearchresult' => [
            'count' => '1',
            'idlist' => ['24710095'],
            'querytranslation' => '"10.3390"[Publisher ID]',
        ]]);

        // Act
        $result = (new EutilsEsearch($identifier, new Output()))->getDataFrom($document);

        // Assert
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_returns_empty_array_when_the_query_translation_is_missing()
    {
        // Arrange
        $identifier = (new IdentifierResolver('10.3390/genes12010001'))->handle();

        $document = json_encode(['esearchresult' => [
            'count' => '1',
            'idlist' => ['33374967'],
        ]]);

        // Act
        $result = (new EutilsEsearch($identifier, new Output()))->getDataFrom($document);

        // Assert
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_returns_empty_array_if_document_is_empty()
    {
        // Arrange
        $identifier = (new IdentifierResolver('10.123/4567'))->handle();

        // Act
        $result = (new EutilsEsearch($identifier, new Output()))->getDataFrom('');

        // Assert
        $this->assertEmpty($result);
    }
}
