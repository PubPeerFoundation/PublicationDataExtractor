<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\Crossref;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\CrossrefUpdates;

class CrossrefDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_publication_data_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Crossref/valid-article');

        // Act
        $extracted = (new Crossref($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            'title' => 'Cholinergic Modulation of Neuronal Excitability in the Accessory Olfactory Bulb',
            'url' => 'http://dx.doi.org/10.1152/jn.00446.2010',
            'published_at' => '2010-12',
            'abstract' => null,
        ], $extracted['publication']);

        $this->assertArrayIsValid($extracted);
    }

    /** @test */
    public function it_can_extract_identifiers_data_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Crossref/valid-article');

        // Act
        $extracted = (new Crossref($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'value' => '10.1152/jn.00446.2010',
                'type' => 'doi',
            ],
            [
                'value' => '0022-3077',
                'type' => 'issn',
            ],
            [
                'value' => '1522-1598',
                'type' => 'issn',
            ],
        ], $extracted['identifiers']);
    }

    /** @test */
    public function it_can_extract_authors_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Crossref/valid-with-orcid-article');

        // Act
        $extracted = (new Crossref($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'first_name' => 'Wei-Shih',
                'last_name' => 'Du',
                'affiliation' => [
                    [
                        'name' => 'Department of Mathematics, National Changhua University of Education, Changhua 500, Taiwan',
                    ],
                ],
            ],
            [
                'first_name' => 'Young-Ye',
                'last_name' => 'Huang',
                'orcid' => 'http://orcid.org/0000-0002-0779-4566',
                'affiliation' => [
                    [
                        'name' => 'Department of Mathematics, National Cheng Kung University, Tainan 701, Taiwan',
                    ],
                ],
            ],
            [
                'first_name' => 'Chi-Lin',
                'last_name' => 'Yen',
                'affiliation' => [
                    [
                        'name' => "Department of Mathematics and Science Education, National Hsinchu Teacher's College, Hsinchu 300, Taiwan",
                    ],
                ],
            ],
        ], $extracted['authors']);
    }

    /** @test */
    public function it_can_extract_updates_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Crossref/valid-with-updates-article');

        // Act
        $extracted = (new CrossrefUpdates($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'timestamp' => '1524096000000',
                'identifier' => [
                    'doi' => '10.1038/s41588-017-0029-0',
                ],
                'type' => 'Corrected',
            ],
        ], $extracted['updates']);
    }
}
