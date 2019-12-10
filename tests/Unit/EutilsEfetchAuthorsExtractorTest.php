<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Unit;

use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\EutilsEfetch;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;

class EutilsEfetchAuthorsExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_will_extract_authors_from_EutilsEfetch_without_affiliation()
    {
        // Arrange
        $identifier = (new IdentifierResolver('145268'))->handle();
        $extractor = new EutilsEfetch('', new Output());

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
        ], $this->getProtectedProperty($extractor, 'resourceOutput'));
    }

    /** @test */
    public function it_will_extract_authors_from_EutilsEfetch_with_affiliation()
    {
        // Arrange
        $identifier = (new IdentifierResolver('145268'))->handle();
        $extractor = new EutilsEfetch('', new Output());

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
                    'affiliation' => [
                        ['name' => 'University of whatever'],
                    ],
                ],
            ],
        ], $this->getProtectedProperty($extractor, 'resourceOutput'));
    }

    /** @test */
    public function it_will_extract_authors_from_EutilsEfetch_without_forename()
    {
        // Arrange
        $identifier = (new IdentifierResolver('145268'))->handle();
        $extractor = new EutilsEfetch('', new Output());

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
                    'affiliation' => [
                        ['name' => 'University of whatever'],
                    ],
                ],
            ],
        ], $this->getProtectedProperty($extractor, 'resourceOutput'));
    }

    /** @test */
    public function it_wont_extract_authors_from_EutilsEfetch_without_author_list()
    {
        // Arrange
        $identifier = (new IdentifierResolver('145268'))->handle();
        $extractor = new EutilsEfetch('', new Output());

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
        $this->assertEmpty($this->getProtectedProperty($extractor, 'resourceOutput'));
    }
}
