<?php

namespace XavRsl\PublicationDataExtractor\Test\Unit;

use XavRsl\PublicationDataExtractor\Resources\Extractors\Crossref;
use XavRsl\PublicationDataExtractor\Test\TestHelpers;
use XavRsl\PublicationDataExtractor\Test\TestCase;

class CrossrefIdentifiersExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    function it_wont_extract_an_empty_DOI()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', [
            'DOI' => ''
        ]);

        // Act
        $extractor->extractIdentifiersData();

        // Assert
        $this->assertEmpty($this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    function it_wont_extract_a_missing_DOI()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', []);

        // Act
        $extractor->extractIdentifiersData();

        // Assert
        $this->assertEmpty($this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    function it_wont_extract_an_empty_ISSN()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', [
            'ISSN' => ''
        ]);

        // Act
        $extractor->extractIdentifiersData();

        // Assert
        $this->assertEmpty($this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    function it_wont_extract_an_empty_ISSN_array()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', [
            'ISSN' => []
        ]);

        // Act
        $extractor->extractIdentifiersData();

        // Assert
        $this->assertEmpty($this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    function it_wont_extract_a_missing_ISSN()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', []);

        // Act
        $extractor->extractIdentifiersData();

        // Assert
        $this->assertEmpty($this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    function it_will_extract_an_ISSN_as_an_array()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', [
            'ISSN' => ['4561-1234']
        ]);

        // Act
        $extractor->extractIdentifiersData();

        // Assert
        $this->assertArraySubset([
            'identifiers' => [
                [
                    'value' => '4561-1234',
                    'type' => 'issn'
                ]
            ]
        ], $this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    function it_will_extract_multiple_ISSNs_as_an_array()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', [
            'ISSN' => [
                '4561-1234',
                '4561-1235',
            ]
        ]);

        // Act
        $extractor->extractIdentifiersData();

        // Assert
        $this->assertArraySubset([
            'identifiers' => [
                [
                    'value' => '4561-1234',
                    'type' => 'issn'
                ],
                [
                    'value' => '4561-1235',
                    'type' => 'issn'
                ]
            ]
        ], $this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    function it_will_extract_an_ISSN_as_a_string()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', [
            'ISSN' => '4561-1234'
        ]);

        // Act
        $extractor->extractIdentifiersData();

        // Assert
        $this->assertArraySubset([
            'identifiers' => [
                [
                    'value' => '4561-1234',
                    'type' => 'issn'
                ]
            ]
        ], $this->getProtectedProperty($extractor, 'output'));
    }
}