<?php
namespace Bml\CoinBundle\Tests\Builder;

use Bml\CoinBundle\Builder\RawTransactionBuilderFactory;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @group unit
 */
class RawTransactionBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function test()
    {
        $factory = new RawTransactionBuilderFactory();


        $trans = $factory->create();
        $trans->addTransfer('txid_1', 'address_1', 5); // 1 -> 1

        $this->assertEquals('\'[{"txid": "txid_1", "vout": 0}]\'', $trans->getFirstPram());
        $this->assertEquals('\'{"address_1": 5}\'', $trans->getSecondParam());


        $trans->addTransfer('txid_1', 'address_2', 6); // 1 -> 1,2

        $this->assertEquals('\'[{"txid": "txid_1", "vout": 0}, {"txid": "txid_1", "vout": 1}]\'', $trans->getFirstPram());
        $this->assertEquals('\'{"address_1": 5}, {"address_2": 6}\'', $trans->getSecondParam());


        $trans->addTransfer('txid_2', 'address_1', 7); // 1,2 -> 1  | 1 -> 2

        $this->assertEquals('\'[{"txid": "txid_1", "vout": 0}, {"txid": "txid_1", "vout": 1}, {"txid": "txid_2", "vout": 0}]\'', $trans->getFirstPram());
        $this->assertEquals('\'{"address_1": 12}, {"address_2": 6}\'', $trans->getSecondParam());

    }
}
