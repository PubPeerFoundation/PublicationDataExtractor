<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test\Integration;

use PubPeerFoundation\PublicationDataExtractor\ApiDataMerger;
use PubPeerFoundation\PublicationDataExtractor\Test\TestCase;
use PubPeerFoundation\PublicationDataExtractor\ApiDataFetcher;
use PubPeerFoundation\PublicationDataExtractor\IdentifierResolver;

class ApiDataFetcherTest extends TestCase
{
    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_doi_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1152/jn.00446.2010');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(5, $dataFetcher->getData());
    }

    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_pubmed_doi_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1038/s41591-018-0049-z');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(4, $extracted = $dataFetcher->getData());
        $this->assertArrayIsValid($extracted);
    }

    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_arxiv_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('1708.03486');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(1, $dataFetcher->getData());
    }

    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_pubmed_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('13054692');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(1, $dataFetcher->getData());
    }

    /**
     * @test
     * @group internet
     */
    public function it_fetches_data_from_a_doi_book_identifier()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.4337/9781783475360');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(2, $dataFetcher->getData());
    }

    /**
     * @test
     * @group internet
     */
    public function it_lists_errors_from_rejected_api_calls()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1023/B');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();
        $errors = $dataFetcher->getErrors();

        // Assert
        $this->assertEmpty($dataFetcher->getData());
        $this->assertArraySubset(['Doi' => 404, 'Crossref' => 404], $errors);
    }

    /** @test */
    public function it_can_extract_pubmed_ids_from_id_converter()
    {
        // Arrange
        $identifier = new IdentifierResolver('10.1371/journal.pone.0009996');
        $dataFetcher = new ApiDataFetcher($identifier->handle());

        // Act
        $dataFetcher->fetch();

        // Assert
        $this->assertCount(4, $extracted = $dataFetcher->getData());

        $merged = ApiDataMerger::handle($extracted);
        $identifiers = array_merge(...$merged['identifiers']);
        $this->assertTrue(count(array_filter($identifiers, function ($identifier) {
            return 'pubmed' === $identifier['type'];
        })) > 0);
    }

    /**
     * @test
     * @group forever
     */
    public function test_first_150_entries_of_pubpeer_identifiers()
    {
        // Took 3.65 minutes to complete, average .6 seconds per fetch.

        $ids = [
            '10.1016/j.molcel.2017.01.013',
            '28157506',
            '10.1093/humrep/dex008',
            '28166330',
            '10.1111/apt.14044',
            '28318052',
            '10.1073/pnas.1523936113',
            '10.1016/j.neuropharm.2017.04.043',
            '10.1016/j.biomaterials.2015.07.055',
            '26318819',
            '10.1038/546033a',
            '10.1038/leu.2011.62',
            '21494253',
            '10.1016/j.canlet.2013.12.005',
            '10.1080/10408390802064347',
            '10.1016/j.jss.2013.12.028',
            '10.1093/embo-reports/kvf213',
            '12393750',
            '10.1371/journal.pone.0093386',
            '10.1016/j.cell.2015.01.009',
            '11624264',
            '10.1152/ajpheart.00005.2017',
            '28130332',
            '10.1177/1078390316668478',
            '10.3390/vision1010009',
            '10.1016/j.cell.2009.11.030',
            '19962179',
            '10.1074/jbc.M115.693200',
            '26634277',
            '10.1530/REP-17-0063',
            '28420801',
            '10.1002/jum.14272',
            '28586113',
            '10.1007/s00424-017-2007-x',
            '28597189',
            '10.1101/gr.153551.112',
            '23934932',
            '10.1080/0142159X.2017.1324137',
            '10.1016/j.meegid.2017.03.023',
            '28342885',
            '10.1002/hep.26505',
            '10.1152/ajpheart.00281.2016',
            '27986658',
            '10.1016/j.gdata.2015.07.008',
            '26697316',
            '10.1007/s00299-016-1960-8',
            '10.1128/MCB.25.8.3338-3347.2005',
            '15798217',
            '7958844',
            '10.1074/jbc.M400881200',
            '14970224',
            '10.1002/hep.28927',
            '28114741',
            '10.1093/nar/gkw557',
            '27325741',
            '10.1038/ncomms7087',
            '25608663',
            '10.1104/pp.109.141911',
            '10.1158/0008-5472.CAN-09-3114',
            '20197467',
            '10.12688/f1000research.11119.1',
            '28529709',
            '16796559',
            '10.1167/17.5.16',
            '10.1371/journal.pgen.1006810',
            '8386381',
            '10.1136/bmj.b4144',
            '10.1083/jcb.201504117',
            '10.1021/acs.nanolett.7b01464',
            '10.1523/JNEUROSCI.0175-11.2012',
            '10.1111/anae.13938',
            '10.1016/j.ccell.2017.02.017',
            '10.1073/pnas.1221733110',
            '23812746',
            '10.3389/fphar.2017.00275',
            '28559847',
            '10.1080/10408398.2016.1246414',
            '27736161',
            '10.1167/17.6.1',
            '10.1136/bmj.b4330',
            '10.1016/j.devcel.2015.01.012',
            '10.1016/j.meegid.2017.03.023',
            '10.1093/biosci/biw010',
            '10.1016/j.cell.2015.07.047',
            '26317470',
            '10.1002/hep.28927',
            '27831662',
            '10.1167/17.6.2',
            '10.1109/TPWRS.2015.2499700',
            '10.1093/nar/gkw350',
            '27131367',
            '10.1126/science.aai7984',
            '28360327',
            '10.1093/nar/gkv644',
            '26130711',
            '10.1038/srep35422',
            '10.1016/j.heares.2016.12.006',
            '28011083',
            '10.1517/13543784.17.11.1769',
            '18922112',
            '10.1016/j.neuron.2017.05.020',
            '10.1128/MCB.00199-17',
            '10.1016/j.msec.2017.03.207',
            '10.1105/tpc.111.094904',
            '22427335',
            '10.1074/jbc.M610819200',
            '17389604',
            '10.1016/j.bbi.2013.05.005',
            '10.1007/s11948-017-9915-1',
            '10.1038/sj.onc.1204553',
            '11439350',
            '10.1056/NEJMsb1616595',
            '28402238',
            '10.1101/142554',
            '10.1056/NEJMra1612008',
            '28514605',
            '14975242',
            '10.1016/j.clinthera.2017.02.007',
            '28291580',
            '10.4049/jimmunol.0903617',
            '12509522',
            '10.1179/016164107X204693',
            '17626733',
            '10.1074/jbc.M117.794487',
            '28512129',
            '10.4103/0019-509X.175593',
            '10.3758/s13414-016-1160-1',
            '10.1096/fj.06-7947com',
            '17442731',
            '10.1038/ncomms15160',
            '28513586',
            '10.1016/j.amepre.2013.08.019',
            '24355667',
            '6191871',
            '10.1111/mpp.12417',
            '10.1126/scisignal.2002790',
            '22692423',
            '10.1016/j.bbapap.2011.11.003',
            '22155276',
            '10.1038/nmeth.4293',
            '10.1038/nature22314',
            '10.1523/JNEUROSCI.2086-05.2005',
            '16107656',
            '10.4049/jimmunol.1201651',
            '23028059',
            '10.1016/j.jesp.2010.01.007',
            '10.4161/auto.19653',
            '22576015',
            '10.1002/1873-3468.12657',
        ];

        // Act
        foreach ($ids as $id) {
            $identifier = new IdentifierResolver($id);
            $dataFetcher = new ApiDataFetcher($identifier->handle());

            $dataFetcher->fetch();

            $extracted = $dataFetcher->getData();

            var_dump(count($extracted));
        }
    }
}
