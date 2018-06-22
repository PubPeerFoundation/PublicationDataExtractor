<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\BioRxiv;

class BioArxivDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_journal_data_from_biorxiv_api()
    {
        // Arrange
        $file = $this->loadJson('BioRxiv/valid-article');

        // Act
        $extracted = (new BioRxiv($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            'title' => 'BioRxiv',
        ], $extracted['journal']);

        $this->assertArrayIsValid($extracted);
    }
}
