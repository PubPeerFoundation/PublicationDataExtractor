<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\Fetcher;
use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;

class OutputTest extends TestCase
{
    /**
     * @test
     * @group forever
     */
    public function test_20_randomly_selected_identifiers()
    {
        $ids = [
            '24834831',
            '1406.0755v3',
            //            '10.1038/s41591-018-0058-y',
            //            '10.1016/j.biomaterials.2013.04.055',
            //            '23702148',
            //            '21035459',
            //            '10.1016/j.jmb.2010.10.030',
            //            '28430426',
            //            '10.1021/acs.jctc.7b00125',
            //            '12610298',
            //            '10.1126/science.1079731',
            //            '10.1126/science.1236077',
            //            '23744776',
            //            '10.1038/ncomms12562',
            //            '27558844',
            //            '10.1021/acsnano.7b05503',
            //            '29019651',
            //            '10.1016/s0001-4575(99)00042-1',
            //            '212431',
            //            '10.1101/212431',
            //            '10.1177/1090820x12472902',
            //            '23335644',
            //            '28776029',
            //            '10.1016/s0195-6663(03)00120-x',
            //            '29767272',
        ];

        // Act
        foreach ($ids as $id) {
            $identifier = new IdentifierResolver($id);
            $dataFetcher = new Fetcher($identifier->handle());

            $output = $dataFetcher->fetch();

            $this->assertArrayIsValid($output->getData());
        }
    }
}
