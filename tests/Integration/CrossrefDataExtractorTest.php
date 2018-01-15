<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnparseableApiException;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\Crossref;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class CrossrefDataExtractorTest extends TestCase
{
    /** @test */
    function it_throws_an_exception_if_status_is_not_ok()
    {
        // Arrange
        $file = $this->loadJson('Crossref/not-ok-article');

        // Assert
        $this->expectException(UnparseableApiException::class);

        // Act
        (new Crossref($file))->extract();
    }

    /** @test */
    function it_can_extract_publication_data_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Crossref/valid-article');

        // Act
        $extracted = (new Crossref($file))->extract();

        // Assert
        $this->assertArraySubset([
            'title' =>  'Cholinergic Modulation of Neuronal Excitability in the Accessory Olfactory Bulb',
            'url'   =>  'http://dx.doi.org/10.1152/jn.00446.2010',
            'published_at'  =>  '2010-12',
            'abstract' => NULL
        ], $extracted['publication']);
    }

    /** @test */
    function it_can_extract_identifiers_data_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Crossref/valid-article');;

        // Act
        $extracted = (new Crossref($file))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'value' => '10.1152/jn.00446.2010',
                'type' => 'doi'
            ],
            [
                'value' => '0022-3077',
                'type' => 'issn'
            ],
            [
                'value' => '1522-1598',
                'type' => 'issn'
            ],
        ], $extracted['identifiers']);
    }

    /** @test */
    function it_can_extract_authors_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Crossref/valid-with-orcid-article');

        // Act
        $extracted = (new Crossref($file))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'first_name' => 'Wei-Shih',
                'last_name' => 'Du',
                'affiliation' => [
                    [
                        "name" => "Department of Mathematics, National Changhua University of Education, Changhua 500, Taiwan"
                    ]
                ]
            ],
            [
                'first_name' => 'Young-Ye',
                'last_name' => 'Huang',
                'orcid' => 'http://orcid.org/0000-0002-0779-4566',
                'affiliation' => [
                    [
                        "name" => "Department of Mathematics, National Cheng Kung University, Tainan 701, Taiwan"
                    ]
                ]
            ],
            [
                'first_name' => 'Chi-Lin',
                'last_name' => 'Yen',
                'affiliation' => [
                    [
                        "name" => "Department of Mathematics and Science Education, National Hsinchu Teacher's College, Hsinchu 300, Taiwan"
                    ]
                ]
            ],
        ], $extracted['authors']);
    }

    /** @test */
    function it_can_extract_updates_from_crossref_api()
    {
        // Arrange
        $file = $this->loadJson('Crossref/valid-with-updates-article');

        // Act
        $extracted = (new Crossref($file))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'timestamp' => '1517443200000',
                'identifier' => [
                    'doi' => '10.1016/j.canlet.2012.01.013',
                ],
                'type' => 'Erratum',
            ]
        ], $extracted['updates']);

    }

    public function loadJson($name)
    {
        return json_decode(file_get_contents(__DIR__ . '/stubs/'.$name.'.json'), true);
    }
}