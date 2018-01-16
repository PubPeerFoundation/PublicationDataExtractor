<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Unit;

use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\EutilsEfetch;

class EutilsEfetchAuthorsExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_will_extract_authors_from_EutilsEfetch_without_affiliation()
    {
        // Arrange
        $identifier = (new Identifier('145268'))->resolve();
        $extractor = new EutilsEfetch('', $identifier);

        $this->setProtectedProperty($extractor, 'searchTree', new \SimpleXMLElement('
            <PubmedArticle>
                <MedlineCitation Status="MEDLINE" Owner="NLM">
                    <Article PubModel="Print">
                        <AuthorList CompleteYN="Y">
                            <Author ValidYN="Y">
                                <LastName>Pye</LastName>
                                <ForeName>R J</ForeName>
                                <Initials>RJ</Initials>
                            </Author>
                        </AuthorList>
                    </Article>
                </MedlineCitation>
            </PubmedArticle>
        '));

        // Act
        $extractor->extractAuthorsData();

        // Assert
        $this->assertArraySubset([
            'authors' => [
                [
                    'first_name' => 'R J',
                    'last_name' => 'Pye',
                ],
            ],
        ], $this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    public function it_will_extract_authors_from_EutilsEfetch_with_affiliation()
    {
        // Arrange
        $identifier = (new Identifier('145268'))->resolve();
        $extractor = new EutilsEfetch('', $identifier);

        $this->setProtectedProperty($extractor, 'searchTree', new \SimpleXMLElement('
            <PubmedArticle>
                <MedlineCitation Status="MEDLINE" Owner="NLM">
                    <Article PubModel="Print">
                        <AuthorList CompleteYN="Y">
                            <Author ValidYN="Y">
                                <LastName>Pye</LastName>
                                <ForeName>R J</ForeName>
                                <Initials>RJ</Initials>
                                <AffiliationInfo>
                                    <Affiliation>University of whatever</Affiliation>
                                </AffiliationInfo>
                            </Author>
                        </AuthorList>
                    </Article>
                </MedlineCitation>
            </PubmedArticle>
        '));

        // Act
        $extractor->extractAuthorsData();

        // Assert
        $this->assertArraySubset([
            'authors' => [
                [
                    'first_name' => 'R J',
                    'last_name' => 'Pye',
                    'affiliation' => 'University of whatever',
                ],
            ],
        ], $this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    public function it_will_extract_authors_from_EutilsEfetch_without_forename()
    {
        // Arrange
        $identifier = (new Identifier('145268'))->resolve();
        $extractor = new EutilsEfetch('', $identifier);

        $this->setProtectedProperty($extractor, 'searchTree', new \SimpleXMLElement('
            <PubmedArticle>
                <MedlineCitation Status="MEDLINE" Owner="NLM">
                    <Article PubModel="Print">
                        <AuthorList CompleteYN="Y">
                            <Author ValidYN="Y">
                                <LastName>Pye</LastName>
                                <Initials>RJ</Initials>
                                <AffiliationInfo>
                                    <Affiliation>University of whatever</Affiliation>
                                </AffiliationInfo>
                            </Author>
                        </AuthorList>
                    </Article>
                </MedlineCitation>
            </PubmedArticle>
        '));

        // Act
        $extractor->extractAuthorsData();

        // Assert
        $this->assertArraySubset([
            'authors' => [
                [
                    'last_name' => 'Pye',
                    'affiliation' => 'University of whatever',
                ],
            ],
        ], $this->getProtectedProperty($extractor, 'output'));
    }

    /** @test */
    public function it_wont_extract_authors_from_EutilsEfetch_without_author_list()
    {
        // Arrange
        $identifier = (new Identifier('145268'))->resolve();
        $extractor = new EutilsEfetch('', $identifier);

        $this->setProtectedProperty($extractor, 'searchTree', new \SimpleXMLElement('
            <PubmedArticle>
                <MedlineCitation Status="MEDLINE" Owner="NLM">
                    <Article PubModel="Print">
                    </Article>
                </MedlineCitation>
            </PubmedArticle>
        '));

        // Act
        $extractor->extractAuthorsData();

        // Assert
        $this->assertEmpty($this->getProtectedProperty($extractor, 'output'));
    }
}
