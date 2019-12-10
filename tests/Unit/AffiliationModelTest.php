<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Unit;

use PubPeerFoundation\PublicationDataExtractor\Models\Affiliations;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class AffiliationModelTest extends TestCase
{
    /** @test */
    public function it_cant_add_twice_the_same_affiliation()
    {
        Affiliations::getInstance()->add([['name' => 'My affiliation']]);
        Affiliations::getInstance()->add([['name' => 'My affiliation']]);

        $this->assertCount(1, Affiliations::getInstance()->toArray()[0]);
    }

    /** @test */
    public function it_is_case_insensitive()
    {
        Affiliations::getInstance()->add([['name' => 'my Affiliation']]);
        Affiliations::getInstance()->add([['name' => 'My affiliation']]);

        $this->assertCount(1, Affiliations::getInstance()->toArray()[0]);
    }
}
