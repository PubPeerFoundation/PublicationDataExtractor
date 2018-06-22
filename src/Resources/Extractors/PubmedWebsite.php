<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class PubmedWebsite extends Extractor implements ProvidesIdentifiersData, ProvidesAffiliationsData
{
    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * Create search tree.
     */
    protected function getDataFromDocument()
    {
        $this->crawler = new Crawler();
        $this->crawler->addHtmlContent($this->document);
    }

    /**
     * Extract and format data needed for the Identifiers Relationship
     * on the Publication Model.
     */
    public function extractIdentifiersData(): void
    {
        $pubmed = stringify($this->crawler->evaluate('string(//input[@id="absid"]/@value)'));

        if (! empty($pubmed)) {
            $this->resourceOutput['identifiers'][] = [
                'value' => $pubmed,
                'type' => 'pubmed',
            ];
        }
    }

    /**
     * Extract and format data needed for the Affiliations Relationship
     * on the Publication Model.
     */
    public function extractAffiliationsData(): void
    {
        $affiliations = $this->crawler->evaluate('//div[@class="afflist"]/dl/dd');

        foreach ($affiliations as $affiliation) {
            $this->resourceOutput['affiliations'][] = [
                'name' => (string) $affiliation->textContent,
            ];
        }
    }
}
