<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Fetcher;
use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class RegressionTest extends TestCase
{
    /** @test */
    public function it_can_extract_issns()
    {
        $identifier = new IdentifierResolver('10.1002/0471142727.mb0418s103');
        $dataFetcher = new Fetcher($identifier->handle());

        $output = $dataFetcher->fetch();

        $this->assertArrayIsValid($output->getData());

        $issnIdentifiers = array_filter($output->getData()['identifiers'], function ($identifier) {
            return 'issn' === $identifier['type'];
        });

        $this->assertCount(1, $issnIdentifiers);
        $this->assertTrue('John Wiley & Sons, Inc.' === $output->getData()['journal']['publisher']);
        $this->assertCount(1, $output->getData()['journal']['issn']);
    }
}
