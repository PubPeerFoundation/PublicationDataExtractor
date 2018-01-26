<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\IdConverter;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;

class IdConverterDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_throws_an_exception_if_status_is_not_ok()
    {
        // Arrange
        $file = $this->loadJson('IdConverter/not-ok-article');

        // Assert
        $this->expectException(UnparseableApiException::class);

        // Act
        (new IdConverter($file))->extract();
    }

    /** @test */
    public function it_can_extract_identifiers_data_from_id_converter_api()
    {
        // Arrange
        $file = $this->loadJson('IdConverter/valid-article');

        // Act
        $extracted = (new IdConverter($file))->extract();

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
