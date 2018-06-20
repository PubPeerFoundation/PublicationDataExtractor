<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class PubmedWebsite implements Extractor, ProvidesIdentifiersData, ProvidesAffiliationsData
{
    /**
     * @var array
     */
    protected $document;

    /**
     * @var array
     */
    protected $searchTree;

    /**
     * @var array
     */
    protected $output = [];

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * PubmedWebsite constructor.
     *
     * @param $document
     */
    public function __construct($document)
    {
        $this->crawler = new Crawler();
        $this->crawler->addHtmlContent($document);
    }

    /**
     * @return array
     */
    public function extract(): array
    {
        $this->extractIdentifiersData();
        $this->extractAffiliationsData();

        return $this->output;
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData()
    {
        $pubmed = stringify($this->crawler->evaluate('string(//input[@id="absid"]/@value)'));

        if (! empty($pubmed)) {
            $this->output['identifiers'][] = [
                'value' => $pubmed,
                'type' => 'pubmed',
            ];
        }
    }

    /**
     * Extract and format data needed for the Affiliations Relationship
     * on the Publication Model.
     */
    public function extractAffiliationsData()
    {
        $affiliations = $this->crawler->evaluate('//div[@class="afflist"]/dl/dd');

        foreach ($affiliations as $affiliation) {
            $this->output['affiliations'][] = [
                'name' => (string) $affiliation->textContent,
            ];
        }
    }
}
