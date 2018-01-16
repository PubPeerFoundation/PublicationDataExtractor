<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\BioRxiv;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;

class BioArxivDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_journal_data_from_biorxiv_api()
    {
        // Arrange
        $file = $this->loadJson('BioRxiv/valid-article');

        // Act
        $extracted = (new BioRxiv($file))->extract();

        // Assert
        $this->assertArraySubset([
            'title' => 'BioRxiv',
        ], $extracted['journal']);
    }
}
