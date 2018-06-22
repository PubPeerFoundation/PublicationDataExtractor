<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Unit;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\Crossref;

class CrossrefJournalExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_will_extract_an_ISSN_as_an_array()
    {
        // Arrange
        $extractor = new Crossref('', new Output());

        $this->setProtectedProperty($extractor, 'searchTree', [
            'container-title' => 'blabla',
            'ISSN' => ['4561-1234'],
            'publisher' => 'blibli',
        ]);

        // Act
        $extractor->extractJournalData();

        // Assert
        $this->assertArraySubset([
            'journal' => [
                'title' => 'blabla',
                'issn' => ['4561-1234'],
                'publisher' => 'blibli',
            ],
        ], $this->getProtectedProperty($extractor, 'resourceOutput'));
    }

    /** @test */
    public function it_will_extract_multiple_ISSNs_as_an_array()
    {
        // Arrange
        $extractor = new Crossref('', new Output());

        $this->setProtectedProperty($extractor, 'searchTree', [
            'container-title' => 'blabla',
            'publisher' => 'blibli',
            'ISSN' => [
                '4561-1234',
                '4561-1235',
            ],
        ]);

        // Act
        $extractor->extractJournalData();

        // Assert
        $this->assertArraySubset([
            'journal' => [
                'title' => 'blabla',
                'publisher' => 'blibli',
                'issn' => [
                    '4561-1234',
                    '4561-1235',
                ],
            ],
        ], $this->getProtectedProperty($extractor, 'resourceOutput'));
    }

    /** @test */
    public function it_will_extract_an_ISSN_as_a_string()
    {
        // Arrange
        $extractor = new Crossref('', new Output());

        $this->setProtectedProperty($extractor, 'searchTree', [
            'container-title' => 'blabla',
            'publisher' => 'blibli',
            'ISSN' => '4561-1234',
        ]);

        // Act
        $extractor->extractJournalData();

        // Assert
        $this->assertArraySubset([
            'journal' => [
                'title' => 'blabla',
                'publisher' => 'blibli',
                'issn' => [
                    '4561-1234',
                ],
            ],
        ], $this->getProtectedProperty($extractor, 'resourceOutput'));
    }
}
