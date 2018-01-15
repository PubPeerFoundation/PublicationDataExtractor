<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Unit;

use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\Crossref;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class CrossrefPublicationExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    function it_can_extract_a_title_as_an_array()
    {
        // Arrange
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', [
            'title' => ['blabla'],
            'abstract' => 'blibli',
            'URL' => 'bloblo',
            'published-print' => [
                'date-parts' => [
                    [
                        '2010',
                        '12'
                    ]
                ]
            ]
        ]);

        // Act
        $extractor->extractPublicationData();

        // Assert
        $this->assertArraySubset([
            'publication' => [
                'title' =>  'blabla',
                'abstract' => 'blibli',
                'url'   =>  'bloblo',
                'published_at'  =>  '2010-12',
            ]
        ], $this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    function it_can_extract_a_title_as_a_string()
    {
        $extractor = new Crossref('');

        $this->setProtectedProperty($extractor, 'searchTree', [
            'title' => 'blabla',
            'abstract' => 'blibli',
            'URL' => 'bloblo',
            'published-print' => [
                'date-parts' => [
                    [
                        '2010',
                        '12'
                    ]
                ]
            ]
        ]);

        // Act
        $extractor->extractPublicationData();

        // Assert
        $this->assertArraySubset([
            'publication' => [
                'title' =>  'blabla',
                'abstract' => 'blibli',
                'url'   =>  'bloblo',
                'published_at'  =>  '2010-12',
            ]
        ], $this->getProtectedProperty($extractor, 'output'));
    }
}