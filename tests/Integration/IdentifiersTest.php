<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Identifiers\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Doi;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Arxiv;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Pubmed;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\BioArxiv;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Figshare;
use PubPeerFoundation\PublicationDataExtractor\Exceptions\UnknownIdentifierException;

class IdentifiersTest extends TestCase
{
    /** @test */
    public function it_identifies_an_arxiv_identifier()
    {
        // Arrange
        $validArxiv = '1712.05752';
        $result = new IdentifierResolver($validArxiv);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('1712.05752', $identifier);

        $this->assertInstanceOf(Arxiv::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_bio_arxiv_identifier()
    {
        // Arrange
        $validBioArxiv = '10.1101/234369';
        $result = new IdentifierResolver($validBioArxiv);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('10.1101/234369', $identifier);

        $this->assertInstanceOf(BioArxiv::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_doi_identifier()
    {
        // Arrange
        $validDoi = '10.1038/srep07802';
        $result = new IdentifierResolver($validDoi);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('10.1038/srep07802', $identifier);

        $this->assertInstanceOf(Doi::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_figshare_identifier()
    {
        // Arrange
        $validFigshare = '10.6084/m9.figshare.5673715.v2';
        $result = new IdentifierResolver($validFigshare);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('10.6084/m9.figshare.5673715.v2', $identifier);

        $this->assertInstanceOf(Figshare::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_pubmed_identifier()
    {
        // Arrange
        $validPubmed = '28658642';
        $result = new IdentifierResolver($validPubmed);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('28658642', $identifier);

        $this->assertInstanceOf(Pubmed::class, $identifier);
    }

    /** @test */
    public function it_identifies_an_arxiv_identifier_contained_in_the_query()
    {
        // Arrange
        $validArxiv = 'arxiv: 1712.05752';
        $result = new IdentifierResolver($validArxiv);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('1712.05752', $identifier);

        $this->assertInstanceOf(Arxiv::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_bio_arxiv_identifier_contained_in_the_query()
    {
        // Arrange
        $validBioArxiv = 'bioarxiv: 10.1101/234369';
        $result = new IdentifierResolver($validBioArxiv);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('10.1101/234369', $identifier);

        $this->assertInstanceOf(BioArxiv::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_doi_identifier_contained_in_the_query()
    {
        // Arrange
        $validDoi = 'doi: 10.1038/srep07802';
        $result = new IdentifierResolver($validDoi);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('10.1038/srep07802', $identifier);

        $this->assertInstanceOf(Doi::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_figshare_identifier_contained_in_the_query()
    {
        // Arrange
        $validFigshare = 'figshare: 10.6084/m9.figshare.5673715.v2';
        $result = new IdentifierResolver($validFigshare);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('10.6084/m9.figshare.5673715.v2', $identifier);

        $this->assertInstanceOf(Figshare::class, $identifier);
    }

    /** @test */
    public function it_creates_a_valid_arxiv_link()
    {
        // Arrange
        $validArxiv = '1712.05752';
        $result = new IdentifierResolver($validArxiv);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('https://arxiv.org/abs/1712.05752', $identifier->getUrl());
    }

    /** @test */
    public function it_creates_a_valid_bio_arxiv_link()
    {
        // Arrange
        $validBioArxiv = '10.1101/234369';
        $result = new IdentifierResolver($validBioArxiv);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('http://dx.doi.org/10.1101/234369', $identifier->getUrl());
    }

    /** @test */
    public function it_creates_a_valid_doi_link()
    {
        // Arrange
        $validDoi = '10.1038/srep07802';
        $result = new IdentifierResolver($validDoi);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('http://dx.doi.org/10.1038/srep07802', $identifier->getUrl());
    }

    /** @test */
    public function it_creates_a_valid_figshare_link()
    {
        // Arrange
        $validFigshare = '10.6084/m9.figshare.5673715.v2';
        $result = new IdentifierResolver($validFigshare);

        // Act
        $identifier = $result->handle();

        // Assert
        $this->assertEquals('http://dx.doi.org/10.6084/m9.figshare.5673715.v2', $identifier->getUrl());
    }

    /** @test */
    public function it_throws_an_exception_on_unrecognised_identifier()
    {
        // Assert
        $this->expectException(UnknownIdentifierException::class);

        // Arrange
        $validPubmed = 'FakeIdentifier';
        $result = new IdentifierResolver($validPubmed);

        // Act
        $result->handle();
    }
}
