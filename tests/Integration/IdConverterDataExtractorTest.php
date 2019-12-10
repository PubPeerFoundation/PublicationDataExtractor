<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\IdConverter;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;

class IdConverterDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_identifiers_data_from_id_converter_api()
    {
        // Arrange
        $file = $this->loadJson('IdConverter/valid-article');

        // Act
        $extracted = (new IdConverter($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'value' => 'PMC5404503',
                'type' => 'pmc',
            ],
            [
                'value' => '28157506',
                'type' => 'pubmed',
            ],
            [
                'value' => '10.1016/j.molcel.2017.01.013',
                'type' => 'doi',
            ],
        ], $extracted['identifiers']);
    }
}
