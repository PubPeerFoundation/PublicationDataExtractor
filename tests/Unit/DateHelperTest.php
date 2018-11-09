<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Unit;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Support\DateHelper;

class DateHelperTest extends TestCase
{
    /** @test */
    public function it_generates_a_valid_date_string_from_an_array()
    {
        // Arrange
        $parts = [
            2010,
            9,
            23,
        ];

        // Act
        $dateString = date_from_parts($parts);

        // Assert
        $this->assertEquals('2010-09-23', $dateString);
    }

    /** @test */
    public function it_generates_a_valid_date_string_from_an_incomplete_date_parts_array()
    {
        // Arrange
        $parts1 = [
            2010,
            9,
        ];
        $parts2 = [
            2010,
        ];

        // Act
        $dateString1 = date_from_parts($parts1);
        $dateString2 = date_from_parts($parts2);

        // Assert
        $this->assertEquals('2010-09', $dateString1);
        $this->assertEquals('2010', $dateString2);
    }

    /** @test */
    public function it_generates_an_empty_string_from_empty_parts_array()
    {
        // Arrange
        $parts = [];

        // Act
        $dateString = date_from_parts($parts);

        // Assert
        $this->assertEquals('', $dateString);
    }

    /** @test */
    public function it_generates_a_valid_date_string_from_an_object()
    {
        // Arrange
        $parts = new \SimpleXMLElement('<PubMedPubDate PubStatus="pubmed">
            <Year>1977</Year>
            <Month>12</Month>
            <Day>17</Day>
        </PubMedPubDate>');

        // Act
        $dateString = (new DateHelper())->dateFromPubDate($parts);

        // Assert
        $this->assertEquals('1977-12-17', $dateString);
    }

    /** @test */
    public function it_generates_a_valid_date_string_from_an_object_containing_string_month()
    {
        // Arrange
        $parts = new \SimpleXMLElement('<PubMedPubDate PubStatus="pubmed">
            <Year>1977</Year>
            <Month>Dec</Month>
            <Day>17</Day>
        </PubMedPubDate>');

        // Act
        $dateString = (new DateHelper())->dateFromPubDate($parts);

        // Assert
        $this->assertEquals('1977-12-17', $dateString);
    }

    /** @test */
    public function it_generates_a_valid_date_string_from_an_incomplete_date_parts_object()
    {
        // Arrange
        $parts1 = new \SimpleXMLElement('<PubMedPubDate PubStatus="pubmed">
            <Year>1977</Year>
            <Month>12</Month>
        </PubMedPubDate>');

        $parts2 = new \SimpleXMLElement('<PubMedPubDate PubStatus="pubmed">
            <Year>1977</Year>
        </PubMedPubDate>');

        // Act
        $dateString1 = (new DateHelper())->dateFromPubDate($parts1);
        $dateString2 = (new DateHelper())->dateFromPubDate($parts2);

        // Assert
        $this->assertEquals('1977-12', $dateString1);
        $this->assertEquals('1977', $dateString2);
    }

    /** @test */
    public function it_generates_an_empty_string_from_empty_parts_object()
    {
        // Arrange
        $parts = new \SimpleXMLElement('<PubMedPubDate PubStatus="pubmed">
            <Year></Year>
            <Month></Month>
            <Day></Day>
        </PubMedPubDate>');

        // Act
        $dateString = (new DateHelper())->dateFromPubDate($parts);

        // Assert
        $this->assertEquals('', $dateString);
    }

    /** @test */
    public function it_generates_a_valid_carbon_object_from_a_human_readable_format()
    {
        // Arrange
        $string = '2011 Nov 01';

        // Act
        $dateString = DateHelper::dateFromHumanReadable($string);

        // Assert
        $this->assertEquals('2011', $dateString->year);
        $this->assertEquals('11', $dateString->month);
        $this->assertEquals('01', $dateString->day);
    }

    /** @test */
    public function it_generates_a_valid_carbon_object_from_an_incomplete_human_readable_format()
    {
        // Arrange
        $string = '2011 Nov';

        // Act
        $dateString = DateHelper::dateFromHumanReadable($string);

        // Assert
        $this->assertEquals('2011', $dateString->year);
        $this->assertEquals('11', $dateString->month);
        $this->assertEquals('01', $dateString->day);
    }
}
