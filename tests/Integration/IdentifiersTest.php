<?php

namespace XavRsl\PublicationDataExtractor\Test\Integration;

use XavRsl\PublicationDataExtractor\Test\TestCase;
use XavRsl\PublicationDataExtractor\Identifiers\Doi;
use XavRsl\PublicationDataExtractor\Identifiers\Arxiv;
use XavRsl\PublicationDataExtractor\Identifiers\Pubmed;
use XavRsl\PublicationDataExtractor\Identifiers\Figshare;
use XavRsl\PublicationDataExtractor\Identifiers\BioArxiv;
use XavRsl\PublicationDataExtractor\Identifiers\Identifier;
use XavRsl\PublicationDataExtractor\Exceptions\UnknownIdentifierException;

class IdentifiersTest extends TestCase
{
    /** @test */
    public function it_identifies_an_arxiv_identifier()
    {
        // Arrange
        $validArxiv = '1712.05752';
        $result = new Identifier($validArxiv);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('1712.05752', $identifier);

        $this->assertInstanceOf(Arxiv::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_bio_arxiv_identifier()
    {
        // Arrange
        $validBioArxiv = '10.1101/234369';
        $result = new Identifier($validBioArxiv);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('10.1101/234369', $identifier);

        $this->assertInstanceOf(BioArxiv::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_doi_identifier()
    {
        // Arrange
        $validDoi = '10.1038/srep07802';
        $result = new Identifier($validDoi);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('10.1038/srep07802', $identifier);

        $this->assertInstanceOf(Doi::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_figshare_identifier()
    {
        // Arrange
        $validFigshare = '10.6084/m9.figshare.5673715.v2';
        $result = new Identifier($validFigshare);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('10.6084/m9.figshare.5673715.v2', $identifier);

        $this->assertInstanceOf(Figshare::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_pubmed_identifier()
    {
        // Arrange
        $validPubmed = '28658642';
        $result = new Identifier($validPubmed);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('28658642', $identifier);

        $this->assertInstanceOf(Pubmed::class, $identifier);
    }

    /** @test */
    public function it_identifies_an_arxiv_identifier_contained_in_the_query()
    {
        // Arrange
        $validArxiv = 'arxiv: 1712.05752';
        $result = new Identifier($validArxiv);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('1712.05752', $identifier);

        $this->assertInstanceOf(Arxiv::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_bio_arxiv_identifier_contained_in_the_query()
    {
        // Arrange
        $validBioArxiv = 'bioarxiv: 10.1101/234369';
        $result = new Identifier($validBioArxiv);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('10.1101/234369', $identifier);

        $this->assertInstanceOf(BioArxiv::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_doi_identifier_contained_in_the_query()
    {
        // Arrange
        $validDoi = 'doi: 10.1038/srep07802';
        $result = new Identifier($validDoi);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('10.1038/srep07802', $identifier);

        $this->assertInstanceOf(Doi::class, $identifier);
    }

    /** @test */
    public function it_identifies_a_figshare_identifier_contained_in_the_query()
    {
        // Arrange
        $validFigshare = 'figshare: 10.6084/m9.figshare.5673715.v2';
        $result = new Identifier($validFigshare);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('10.6084/m9.figshare.5673715.v2', $identifier);

        $this->assertInstanceOf(Figshare::class, $identifier);
    }

    /** @test */
    public function it_creates_a_valid_arxiv_link()
    {
        // Arrange
        $validArxiv = '1712.05752';
        $result = new Identifier($validArxiv);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('https://arxiv.org/abs/1712.05752', $identifier->getUrl());
    }

    /** @test */
    public function it_creates_a_valid_bio_arxiv_link()
    {
        // Arrange
        $validBioArxiv = '10.1101/234369';
        $result = new Identifier($validBioArxiv);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('http://dx.doi.org/10.1101/234369', $identifier->getUrl());
    }

    /** @test */
    public function it_creates_a_valid_doi_link()
    {
        // Arrange
        $validDoi = '10.1038/srep07802';
        $result = new Identifier($validDoi);

        // Act
        $identifier = $result->resolve();

        // Assert
        $this->assertEquals('http://dx.doi.org/10.1038/srep07802', $identifier->getUrl());
    }

    /** @test */
    public function it_creates_a_valid_figshare_link()
    {
        // Arrange
        $validFigshare = '10.6084/m9.figshare.5673715.v2';
        $result = new Identifier($validFigshare);

        // Act
        $identifier = $result->resolve();

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
        $result = new Identifier($validPubmed);

        // Act
        $result->resolve();
    }
}
