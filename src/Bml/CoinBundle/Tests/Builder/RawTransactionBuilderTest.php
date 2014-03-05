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
        $trans->addInput('txid_1', 0);
        $trans->addOutput('address_1', 5);

        $this->assertEquals([['txid' => 'txid_1', 'vout' => 0]], $trans->getInput());
        $this->assertEquals(['address_1' => 5], $trans->getOutput());

        $trans->addOutput('address_2', 6);

        $this->assertEquals([['txid' => 'txid_1', 'vout' => 0]], $trans->getInput());
        $this->assertEquals(['address_1' => 5, 'address_2' => 6], $trans->getOutput());


        $trans->addInput('txid_2', 1);

        $this->assertEquals([['txid' => 'txid_1', 'vout' => 0], ['txid' => 'txid_2', 'vout' => 1]], $trans->getInput());
        $this->assertEquals(['address_1' => 5, 'address_2' => 6], $trans->getOutput());

    }
}
