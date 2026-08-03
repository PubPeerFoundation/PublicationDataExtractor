<?php

namespace PubPeerFoundation\PublicationDataExtractor\Resources;

class EutilsEsearch extends Resource
{
    /**
     * @var string
     */
    protected $url = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi';

    /**
     * @var array
     */
    protected $queryStringParameters = [
        'query' => [
            'db' => 'pubmed',
            'version' => '2.0',
            'retmode' => 'json',
            'term' => '',
            'field' => 'AID',
        ],
    ];

    /**
     * @return array
     */
    public function getRequestOptions(): array
    {
        $this->queryStringParameters['query']['term'] = $this->identifier->getQueryString();

        return $this->queryStringParameters;
    }

    /**
     * @param  string  $document
     * @return array
     */
    public function getDataFrom(string $document): array
    {
        try {
            $baseTree = json_decode($document, true);

            if (! $this->matchedTheWholeIdentifier($baseTree)) {
                return [];
            }

            $extractor = new Extractors\EutilsEsearch($baseTree, $this->output);

            return $extractor->extract();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * When a DOI is absent from PubMed, esearch does not return zero hits: it
     * truncates the [Publisher ID] phrase to its longest indexed prefix and
     * searches that instead. `10.3390/anything-not-in-pubmed` degrades to
     * `"10.3390"[Publisher ID]`, which matches exactly one record whose PII is
     * literally `10.3390` — so count is 1 and an unrelated PMID looks like a
     * clean hit.
     *
     * PubMed reports what it really searched in `querytranslation`. Only trust
     * the result when that still spells out the whole identifier.
     */
    protected function matchedTheWholeIdentifier($baseTree): bool
    {
        $translation = $baseTree['esearchresult']['querytranslation'] ?? null;

        if (! is_string($translation)) {
            return false;
        }

        return $this->normalise($translation) === $this->normalise($this->identifier->getQueryString());
    }

    /**
     * Reduce to alphanumerics: PubMed rewrites `10.3390/genes12010001` as
     * `"10 3390 genes12010001"[Publisher ID]`, so punctuation, quoting and the
     * field tag all have to go before the two can be compared.
     */
    protected function normalise(string $value): string
    {
        $value = preg_replace('/\[[^\]]*\]/', '', $value);

        return strtolower(preg_replace('/[^a-z0-9]+/i', '', $value));
    }
}
