<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\Figshare;

class FigshareDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_journal_data_from_figshare_api()
    {
        // Arrange
        $file = $this->loadJson('Figshare/valid-article');

        // Act
        $extracted = (new Figshare($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            'title' => 'Figshare',
        ], $extracted['journal']);

        $this->assertArrayIsValid($extracted);
    }
}
