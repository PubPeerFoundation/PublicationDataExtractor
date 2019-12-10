<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Unit;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\Crossref;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;

class CrossrefPublicationExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_a_title_as_an_array()
    {
        // Arrange
        $extractor = new Crossref('', new Output());

        $this->setProtectedProperty($extractor, 'searchTree', [
            'title' => ['blabla'],
            'abstract' => 'blibli',
            'URL' => 'bloblo',
            'published-print' => [
                'date-parts' => [
                    [
                        '2010',
                        '12',
                    ],
                ],
            ],
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
            ],
        ], $this->getProtectedProperty($extractor, 'resourceOutput'));
    }

    /** @test */
    public function it_can_extract_a_title_as_a_string()
    {
        $extractor = new Crossref('', new Output());

        $this->setProtectedProperty($extractor, 'searchTree', [
            'title' => 'blabla',
            'abstract' => 'blibli',
            'URL' => 'bloblo',
            'published-print' => [
                'date-parts' => [
                    [
                        '2010',
                        '12',
                    ],
                ],
            ],
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
            ],
        ], $this->getProtectedProperty($extractor, 'resourceOutput'));
    }
}
