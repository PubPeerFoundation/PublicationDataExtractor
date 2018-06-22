<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\Doi;

class DoiDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_publication_data_from_doi_api()
    {
        // Arrange
        $file = $this->loadJson('Doi/valid-article');

        // Act
        $extracted = (new Doi($file, new Output()))->extract();

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
    public function it_can_extract_identifiers_data_from_doi_api()
    {
        // Arrange
        $file = $this->loadJson('Doi/valid-article');

        // Act
        $extracted = (new Doi($file, new Output()))->extract();

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

        $this->assertArrayIsValid($extracted);
    }

    /** @test */
    public function it_can_extract_authors_from_doi_api()
    {
        // Arrange
        $file = $this->loadJson('Doi/valid-with-orcid-article');

        // Act
        $extracted = (new Doi($file, new Output()))->extract();

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

        $this->assertArrayIsValid($extracted);
    }

    /** @test */
    public function it_can_extract_updates_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Doi/valid-with-updates-article');

        // Act
        $extracted = (new Doi($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'timestamp' => '1517443200000',
                'identifier' => [
                    'doi' => '10.1016/j.canlet.2012.01.013',
                ],
                'type' => 'Erratum',
            ],
        ], $extracted['updates']);

        $this->assertArrayIsValid($extracted);
    }
}
