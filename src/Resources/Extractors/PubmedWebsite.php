<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources\Extractors;

use Symfony\Component\DomCrawler\Crawler;

class PubmedWebsite implements Extractor, ProvidesIdentifiersData, ProvidesAffiliationsData
{
    protected $document;

    protected $searchTree;

    protected $output = [];

    protected $crawler;

    public function __construct($document)
    {
        $this->crawler = new Crawler();
        $this->crawler->addHtmlContent($document);
    }

    public function extract(): array
    {
        $this->extractIdentifiersData();
        $this->extractAffiliationsData();

        return $this->output;
    }

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
