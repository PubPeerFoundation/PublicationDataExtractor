<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Output;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\Test\TestHelpers;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\Arxiv;

class ArxivDataExtractorTest extends TestCase
{
    use TestHelpers;

    /** @test */
    public function it_can_extract_publication_data_from_arxiv_api()
    {
        // Arrange
        $file = $this->loadXml('arXiv/valid-article');

        // Act
        $extracted = (new Arxiv($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            'title' => 'A Solution of the P versus NP Problem',
            'url' => 'http://arxiv.org/abs/1708.03486v2',
            'published_at' => '2017-08-11',
            'abstract' => 'Berg and Ulfberg and Amano and Maruoka have used CNF-DNF-approximators to
            prove exponential lower bounds for the monotone network complexity of the
            clique function and of Andreev\'s function. We show that these approximators can
            be used to prove the same lower bound for their non-monotone network
            complexity. This implies P not equal NP.',
        ], $extracted['publication']);

        $this->assertArrayIsValid($extracted);
    }

    /** @test */
    public function it_can_extract_identifiers_data_from_arxiv_api()
    {
        // Arrange
        $file = $this->loadXml('arXiv/valid-article');

        // Act
        $extracted = (new Arxiv($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'value' => '1708.03486v2',
                'type' => 'arxiv',
            ],
            [
                'value' => '2331-8422',
                'type' => 'issn',
            ],
        ], $extracted['identifiers']);

        $this->assertArrayIsValid($extracted);
    }

    /** @test */
    public function it_can_extract_authors_from_arxiv_api()
    {
        // Arrange
        $file = $this->loadXml('arXiv/valid-article');

        // Act
        $extracted = (new Arxiv($file, new Output()))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'first_name' => 'Norbert',
                'last_name' => 'Blum',
            ],
        ], $extracted['authors']);

        $this->assertArrayIsValid($extracted);
    }
}
