<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\ApiDataChecker;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use Volan\Volan;

class ApiDataCheckerTest extends TestCase
{
    protected $mergedData = [
        "authors" => [
            0 => [
                "first_name" => "Chew Hooi",
                "last_name" => "Wong",
                "orcid" => null,
                "affiliation" => []
            ],
            1 => [
                "first_name" => "Kartini Bte",
                "last_name" => "Iskandar",
                "orcid" => null,
                "affiliation" => []
            ],
            2 => [
                "first_name" => "Sanjiv Kumar",
                "last_name" => "Yadav",
                "orcid" => null,
                "affiliation" => []
            ],
            3 => [
                "first_name" => "Jayshree L.",
                "last_name" => "Hirpara",
                "orcid" => null,
                "affiliation" => [],
            ],
            4 => [
                "first_name" => "Thomas",
                "last_name" => "Loh",
                "orcid" => null,
                "affiliation" => []
            ],
            5 => [
                "first_name" => "Shazib",
                "last_name" => "Pervaiz",
                "orcid" => null,
                "affiliation" => []
            ]
        ],
        "identifiers" => [
            0 => [
                "value" => "10.1371/journal.pone.0009996",
                "type" => "doi"
            ],
            1 => [
                "value" => "1932-6203",
                "type" => "issn"
            ]
        ],
        "journal" => [
            "title" => "PLoS ONE",
            "issn" => [
                0 => "1932-6203"
            ],
            "publisher" => "Public Library of Science (PLoS)"
        ],
        "publication" => [
            "title" => "Simultaneous Induction of Non-Canonical Autophagy and Apoptosis in Cancer Cells by ROS-Dependent ERK and JNK Activation",
            "abstract" => null,
            "url" => "http://dx.doi.org/10.1371/journal.pone.0009996",
            "published_at" => "2010-04-02"
        ],
        "types" => [
            0 => [
                "name" => "journal-article"
            ],
        ]
    ];

    /** @test */
    public function it_validates_well_formed_data()
    {
        $result = ApiDataChecker::check($this->mergedData);

        $this->assertEmpty(array_filter($result->getErrorInfo()));
        // Assert
        $this->assertTrue($result->isValid());
    }

    /** @test */
    public function it_does_not_validate_malformed_data()
    {
        $data = $this->mergedData;
        $data['journal']['title'] = [
            "PLoS ONE"
        ];
        $result = ApiDataChecker::check($data);

        $this->assertNotEmpty(array_filter($result->getErrorInfo()));
        // Assert
        $this->assertFalse($result->isValid());
    }
}
