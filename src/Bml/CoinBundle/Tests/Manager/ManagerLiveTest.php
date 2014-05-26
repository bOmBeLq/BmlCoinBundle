<?php

namespace Bml\CoinBundle\Tests\Manager;


use Bml\CoinBundle\Client\CurlClient;
use Bml\CoinBundle\Manager\CoinManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \Mockery as m;
use Bml\CoinBundle\Exception\RequestException;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @group live
 */
class ManagerLiveTest extends WebTestCase
{
    /**
     * @var CoinManager
     */
    private $manager;

    protected function setUp()
    {
        static $manager;
        if (!$manager) {
            $container = static::createClient()->getContainer();
            $manager = $container->get('bml_coin.bitcoin1.manager');
        }

        $this->manager = $manager;
    }

    public function testValidateAddress()
    {
        $address = $this->manager->getNewAddress('test');
        $result = $this->manager->validateAddress($address);
        $this->assertInstanceOf('Bml\CoinBundle\Entity\ValidationResult', $result);
        $this->assertTrue($result->isValid());
        $this->assertTrue($result->isMine());
        $this->assertFalse($result->isScript());
        $this->assertNotNull($result->getPublicKey());
        $this->assertEquals('test', $result->getAccountName());
        $this->assertEquals($address, $result->getAddress());
    }

    public function testGetRawTransaction()
    {
        $lastTx = $this->getLastTx();
        $transaction = $this->manager->getRawTransaction($lastTx);
        $this->assertInstanceOf('Bml\CoinBundle\Entity\RawTransaction', $transaction);
        foreach ($transaction->getVin() as $vin) {
            $this->assertInstanceOf('Bml\CoinBundle\Entity\Vin', $vin);
            if ($vin->getScriptSig()) {
                $this->assertInstanceOf('Bml\CoinBundle\Entity\ScriptSig', $vin->getScriptSig());
            }
        }
        foreach ($transaction->getVout() as $vout) {
            $this->assertInstanceOf('Bml\CoinBundle\Entity\Vout', $vout);
            if ($vout->getScriptPubKey()) {
                $this->assertInstanceOf('Bml\CoinBundle\Entity\ScriptPubKey', $vout->getScriptPubKey());
            }
        }
    }

    public function testGetAddressesByAccountAndGetNewAddress()
    {
        $name = uniqid('x_test_');
        $addresses = $this->manager->getAddressesByAccount($name);
        $this->assertInternalType('array', $addresses);
        $this->assertCount(0, $addresses);

        $newAddress = $this->manager->getNewAddress($name);
        $addresses = $this->manager->getAddressesByAccount($name);
        $this->assertCount(1, $addresses);
        $this->assertEquals([$newAddress], $addresses);

        $newAddress2 = $this->manager->getNewAddress($name);
        $addresses = $this->manager->getAddressesByAccount($name);
        $this->assertCount(2, $addresses);

        $this->assertContains($newAddress, $addresses);
        $this->assertContains($newAddress2, $addresses);
    }


    public function testGetDifficulty()
    {
        $this->assertInternalType('float', $this->manager->getDifficulty());
    }

    public function testGetConnectionCount()
    {
        $this->assertInternalType('int', $this->manager->getConnectionCount());
    }

    public function testGetBlockFunctions()
    {
        $block = $this->manager->getBlockCount() - 1;
        $nextBlock = $block + 1;
        $prevBlock = $block - 1;

        $this->assertGreaterThan(0, $block);

        $hash = $this->manager->getBlockHash($block);
        $this->assertNotEmpty($hash);

        $blockInstance = $this->manager->getBlock($hash);
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Block', $blockInstance);
        $this->assertEquals($blockInstance, $this->manager->getBlockByNumber($block));

        $this->assertEquals($hash, $blockInstance->getHash());
        $this->assertEquals($block, $blockInstance->getNumber());

        $nextBlock = $block = $this->manager->getBlockByNumber($nextBlock);
        $prevBlock = $block = $this->manager->getBlockByNumber($prevBlock);

        $this->assertEquals($blockInstance->getNextBlockHash(), $nextBlock->getHash());
        $this->assertEquals($blockInstance->getPreviousBlockHash(), $prevBlock->getHash());

        $this->assertEquals($nextBlock, $this->manager->getBestBloc());
    }

    public function testGetInfo()
    {
        $info = $this->manager->getInfo();
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Info', $info);
        $this->assertGreaterThan(0, $info->getBlocksCount());
    }

    public function testGetBalance()
    {
        $this->assertInternalType('float', $this->manager->getBalance(""));
    }

    public function testGetAccountAndGetAccountAddress()
    {
        $name = uniqid('x_test_');
        $address = $this->manager->getAccountAddress($name);
        $this->assertEquals($name, $this->manager->getAccount($address));
        $this->assertEquals($address, $this->manager->getAccountAddress($name), 'new address should not be generated');
    }

    /**
     * @return string
     */
    private function getLastTx()
    {
        for ($i = $this->manager->getBlockCount(); $i > 0; $i--) {
            $block = $this->manager->getBlockByNumber($i);
            if (count($block->getTx())) {
                $arr = $block->getTx();
                return array_pop($arr);
            }
        }
    }
}
