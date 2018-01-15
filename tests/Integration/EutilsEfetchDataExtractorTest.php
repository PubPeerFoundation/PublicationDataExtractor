<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Identifiers\Identifier;
use PubPeerFoundation\PublicationDataExtractor\Resources\Extractors\EutilsEfetch;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class EutilsEfetchDataExtractorTest extends TestCase
{
    /** @test */
    public function it_can_extract_publication_data_from_efetch_api()
    {
        // Arrange
        $file = $this->loadXml('EutilsEfetch/valid-article');

        // Act
        $identifier = (new Identifier('145268'))->resolve();
        $extracted = (new EutilsEfetch($file, $identifier))->extract();

        // Assert
        $this->assertArraySubset([
            'title' => 'Effect of oral contraceptives on sebum excretion rate.',
            'url' => 'http://www.ncbi.nlm.nih.gov/pubmed/145268',
            'published_at' => '1977-12-17',
            'abstract' => 'Oral contraceptives containing a high dose of oestrogen reduce the sebum excretion rate (SER) and improve acne vulgaris, but more progestogenic preparations may exacerbate acne. The effect on the SER of several oral contraceptives with varying progestogenic potencies was studied in 81 women. The predominantly progestogenic pills (Eugynon 30, Gynovlar) produced no significant change in SER, whereas the rate in women taking a more oestrogenic pill (Minovlar) was significantly reduced compared with the rate in controls. Progestogens therefore do not exacerbate acne by inducing seborrhoea, but in the doses we studied they nullified the inhibitory effect of oestrogens on the sebaceous glands. Acne-prone women who require an oral contraceptive should be given a predominantly oestrogenic preparation.',
        ], $extracted['publication']);
    }

    /** @test */
    public function it_can_extract_identifiers_data_from_efetch_api()
    {
        // Arrange
        $file = $this->loadXml('EutilsEfetch/valid-article');

        // Act
        $identifier = (new Identifier('145268'))->resolve();
        $extracted = (new EutilsEfetch($file, $identifier))->extract();

        // Assert
        $this->assertCount(3, $extracted['identifiers']);
        $this->assertArraySubset([
            [
                'value' => '145268',
                'type' => 'pubmed',
            ],
            [
                'value' => 'PMC1632706',
                'type' => 'pmc',
            ],
            [
                'value' => '0007-1447',
                'type' => 'issn',
            ],
        ], $extracted['identifiers']);
    }

    /** @test */
    public function it_can_extract_authors_from_efetch_api()
    {
        // Arrange
        $file = $this->loadXml('EutilsEfetch/valid-article');

        // Act
        $identifier = (new Identifier('145268'))->resolve();
        $extracted = (new EutilsEfetch($file, $identifier))->extract();

        // Assert
        $this->assertArraySubset([
            [
                'first_name' => 'R J',
                'last_name' => 'Pye',
            ],
            [
                'first_name' => 'G',
                'last_name' => 'Meyrick',
            ],
            [
                'first_name' => 'M J',
                'last_name' => 'Pye',
            ],
            [
                'first_name' => 'J L',
                'last_name' => 'Burton',
            ],
        ], $extracted['authors']);
    }

    public function loadXml($name)
    {
        return new \SimpleXMLElement(file_get_contents(__DIR__.'/stubs/'.$name.'.xml'));
    }
}
