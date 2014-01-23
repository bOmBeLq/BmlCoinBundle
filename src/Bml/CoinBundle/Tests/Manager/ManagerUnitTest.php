<?php

namespace Bml\CoinBundle\Tests\Manager;


use Bml\CoinBundle\Client\CurlClient;
use Bml\CoinBundle\Builder\RawTransactionBuilder;
use Bml\CoinBundle\Builder\RawTransactionBuilderFactory;
use Bml\CoinBundle\Manager\CoinManager;
use \Mockery as m;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @group unit
 */
class ManagerUnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CoinManager
     */
    private $manager;

    /**
     * @var CurlClient|m\MockInterface
     */
    private $client;

    protected function setUp()
    {
        $this->client = m::mock('Bml\CoinBundle\Client\CurlClient');
        $this->manager = new CoinManager($this->client);
    }

    public function testSignRawTransaction()
    {
        $this->mockClient('signrawtransaction', ['the_hex'], $this->getResponse('sign_raw_transaction'), 1);
        $hex = $this->manager->signRawTransaction('the_hex');
        $this->assertInstanceOf('Bml\CoinBundle\Entity\SignRawTransactionResult', $hex);
        $this->assertEquals('the_signed_hex', $hex->getHex());
        $this->assertFalse($hex->getComplete());
    }

    public function testSendRawTransaction()
    {
        $this->mockClient('sendrawtransaction', ['the_hex'], 'tx_id', 1);
        $this->assertEquals('tx_id', $this->manager->sendRawTransaction('the_hex'));
    }

    public function testGetAccounts()
    {
        $this->mockClient('listaccounts', [], $this->getResponse('list_accounts'), 1);
        $accounts = $this->manager->getAccounts();
        $this->assertCount(3, $accounts);
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Account', $accounts[0]);
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Account', $accounts[1]);
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Account', $accounts[2]);

        $this->assertEquals(0.123, $accounts[0]->getBalance());
        $this->assertEquals(1, $accounts[1]->getBalance());
        $this->assertEquals(500.12345678, $accounts[2]->getBalance());

        $this->assertEquals("", $accounts[0]->getName());
        $this->assertEquals("account_1", $accounts[1]->getName());
        $this->assertEquals("another_account", $accounts[2]->getName());
    }

    public function testKeyPoolRefill()
    {
        $this->mockClient('keypoolrefill', [], null, 1);
        $this->manager->keyPoolRefill();
    }

    public function testGetTxOut()
    {
        $this->mockClient('gettxout', ['tx_id', 0], $this->getResponse('get_tx_out'), 1);
        $out = $this->manager->getTxOut('tx_id', 0);
        $this->assertInstanceOf('Bml\CoinBundle\Entity\TxOut', $out);
        $this->assertEquals('best_block1', $out->getBestBlock());
        $this->assertEquals(1, $out->getConfirmations());
        $this->assertEquals(50, $out->getValue());
        $this->assertEquals(3, $out->getVersion());
        $this->assertTrue($out->getCoinBase());

        $scriptPubKey = $out->getScriptPubKey();
        $this->assertInstanceOf('Bml\CoinBundle\Entity\ScriptPubKey', $scriptPubKey);
        $this->assertEquals('asm1', $scriptPubKey->getAsm());
        $this->assertEquals('hex1', $scriptPubKey->getHex());
        $this->assertEquals(2, $scriptPubKey->getRequiredSignatures());
        $this->assertEquals('type1', $scriptPubKey->getType());

        $addresses = $scriptPubKey->getAddresses();
        $this->assertCount(2, $addresses);
        $this->assertEquals('address1', $addresses[0]);
        $this->assertEquals('address2', $addresses[1]);
    }

    public function testGetRawTransaction()
    {
        $this->mockClient('getrawtransaction', ['tx_id', 1], $this->getResponse('get_raw_transaction'), 1);
        $trans = $this->manager->getRawTransaction('tx_id');
        $this->assertInstanceOf('Bml\CoinBundle\Entity\RawTransaction', $trans);
        $this->assertEquals('hex1', $trans->getHex());
        $this->assertEquals('txid1', $trans->getTx());
        $this->assertEquals(3, $trans->getVersion());
        $this->assertEquals(0, $trans->getLockTime());
        $this->assertEquals('blockhash1', $trans->getBlockHash());
        $this->assertEquals(6, $trans->getConfirmations());
        $this->assertEquals(7, $trans->getTime());
        $this->assertEquals(8, $trans->getBlockTime());

        //// VIN
        $this->assertCount(2, $trans->getVin());

        //// VIN 0
        $vin = $trans->getVin()[0];
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Vin', $vin);
        $this->assertEquals('txid2', $vin->getTx());
        $this->assertEquals(0, $vin->getVout());
        $this->assertEquals(5, $vin->getSequence());

        $scriptSig = $vin->getScriptSig();
        $this->assertInstanceOf('Bml\CoinBundle\Entity\ScriptSig', $scriptSig);
        $this->assertEquals('asm1', $scriptSig->getAsm());
        $this->assertEquals('hex2', $scriptSig->getHex());

        //// VIN 1
        $vin = $trans->getVin()[1];
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Vin', $vin);
        $this->assertEquals('txid3', $vin->getTx());
        $this->assertEquals(1, $vin->getVout());
        $this->assertEquals(6, $vin->getSequence());

        $scriptSig = $vin->getScriptSig();
        $this->assertInstanceOf('Bml\CoinBundle\Entity\ScriptSig', $scriptSig);
        $this->assertEquals('asm2', $scriptSig->getAsm());
        $this->assertEquals('hex2', $scriptSig->getHex());

        //// VOUT
        $this->assertCount(2, $trans->getVout());

        //// VOUT 0
        $vout = $trans->getVout()[0];
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Vout', $vout);
        $this->assertEquals(30, $vout->getValue());
        $this->assertEquals(0, $vout->getN());

        $scriptPubKey = $vout->getScriptPubKey();
        $this->assertInstanceOf('Bml\CoinBundle\Entity\ScriptPubKey', $scriptPubKey);
        $this->assertEquals('asm4', $scriptPubKey->getAsm());
        $this->assertEquals('hex4', $scriptPubKey->getHex());
        $this->assertEquals(1, $scriptPubKey->getRequiredSignatures());
        $this->assertEquals('type2', $scriptPubKey->getType());

        $addresses = $scriptPubKey->getAddresses();
        $this->assertCount(1, $addresses);
        $this->assertEquals('address3', $addresses[0]);

        //// VOUT 1
        $vout = $trans->getVout()[1];
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Vout', $vout);
        $this->assertEquals(55, $vout->getValue());
        $this->assertEquals(1, $vout->getN());

        $scriptPubKey = $vout->getScriptPubKey();
        $this->assertInstanceOf('Bml\CoinBundle\Entity\ScriptPubKey', $scriptPubKey);
        $this->assertEquals('asm3', $scriptPubKey->getAsm());
        $this->assertEquals('hex3', $scriptPubKey->getHex());
        $this->assertEquals(2, $scriptPubKey->getRequiredSignatures());
        $this->assertEquals('type1', $scriptPubKey->getType());

        $addresses = $scriptPubKey->getAddresses();
        $this->assertCount(2, $addresses);
        $this->assertEquals('address1', $addresses[0]);
        $this->assertEquals('address2', $addresses[1]);
    }

    public function testGetInfo()
    {
        $this->mockClient('getinfo', [], $this->getResponse('get_info'), 1);
        $info = $this->manager->getInfo();
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Info', $info);
        $this->assertEquals(1, $info->getVersion());
        $this->assertEquals(2, $info->getProtocolVersion());
        $this->assertEquals(3, $info->getWalletVersion());
        $this->assertEquals(1.5, $info->getBalance());
        $this->assertEquals(4, $info->getBlocksCount());
        $this->assertEquals(0, $info->getTimeOffset());
        $this->assertEquals(5, $info->getConnectionsCount());
        $this->assertEquals('proxy', $info->getProxy());
        $this->assertEquals(8, $info->getDifficulty());
        $this->assertEquals(true, $info->getTestNet());
        $this->assertEquals(9, $info->getKeyPoolOldest());
        $this->assertEquals(10, $info->getKeyPoolSize());
        $this->assertEquals(11, $info->getPayTxFee());
        $this->assertEquals('errors', $info->getErrors());
    }

    public function testGetDifficulty()
    {
        $this->mockClient('getdifficulty', [], 3, 1);
        $this->assertEquals(3, $this->manager->getDifficulty());
    }

    public function testGetConnectionCount()
    {
        $this->mockClient('getconnectioncount', [], 3, 1);
        $this->assertEquals(3, $this->manager->getConnectionCount());
    }

    public function testGetBlock()
    {
        $this->mockClient('getblock', ['the_hash'], $this->getResponse('get_block'), 1);
        $block = $this->manager->getBlock('the_hash');
        $this->assertInstanceOf('Bml\CoinBundle\Entity\Block', $block);
        $this->assertEquals('test_hash', $block->getHash());
        $this->assertEquals(5, $block->getConfirmations());
        $this->assertEquals(6, $block->getSize());
        $this->assertEquals(7, $block->getNumber());
        $this->assertEquals(1, $block->getVersion());
        $this->assertEquals('test_markler_root', $block->getMerkleroot());
        $this->assertEquals(1000, $block->getTime());
        $this->assertEquals(2000, $block->getNonce());
        $this->assertEquals('BITS', $block->getBits());
        $this->assertEquals(1, $block->getDifficulty());
        $this->assertEquals('previous_block_hash', $block->getPreviousBlockHash());
        $this->assertEquals('next_block_hash', $block->getNextBlockHash());

        $this->assertCount(2, $block->getTx());
        $this->assertEquals('test_tx_1', $block->getTx()[0]);
        $this->assertEquals('test_tx_2', $block->getTx()[1]);
    }

    public function testGetBlockHash()
    {
        $this->mockClient('getblockhash', [3], 'the_hash', 1);
        $this->assertEquals('the_hash', $this->manager->getBlockHash(3));
    }

    public function testGetBlockCount()
    {
        $this->mockClient('getblockcount', [], 5, 1);
        $this->assertEquals(5, $this->manager->getBlockCount());
    }

    /**
     * @depends testGetBlockCount
     * @depends testGetBlockHash
     * @depends testGetBlock
     */
    public function testGetBestBlock()
    {
        $this->mockClient('getblockcount', [], 5, 1);
        $this->mockClient('getblockhash', [5], 'hash', 1);
        $this->mockClient('getblock', ['hash'], $this->getResponse('get_block'), 1);

        $this->assertInstanceOf('Bml\CoinBundle\Entity\Block', $this->manager->getBestBloc());
    }

    public function testGetBalance()
    {
        $this->mockClient('getbalance', [$name = 'test', 5], 123, 1);
        $this->assertEquals(123, $this->manager->getBalance($name, 5));
    }

    public function testGetAddressesByAccount()
    {
        $this->mockClient('getaddressesbyaccount', [$name = 'test'], $this->getResponse('addresses_by_account'), 1);
        $this->assertEquals(['address_1', 'address_2'], $this->manager->getAddressesByAccount($name));
    }


    public function testGetAccountAddress()
    {
        $this->mockClient('getaccountaddress', [$name = 'test'], $address = 'address', 1);
        $this->assertEquals($address, $this->manager->getAccountAddress($name));
    }

    public function testGetAccount()
    {
        $this->mockClient('getaccount', [$address = 'test'], $name = 'account_name', 1);
        $this->assertEquals($name, $this->manager->getAccount($address));
    }

    public function testDecodeRawTransaction()
    {
        $this->mockClient('decoderawtransaction', ['transaction-hash'], $this->getResponse('decoderawtransaction1'), 1);
        $this->assertInstanceOf('Bml\CoinBundle\Entity\RawTransaction', $transaction = $this->manager->decodeRawTransaction('transaction-hash'));
        $this->assertEquals('test_txid', $transaction->getTx());
        $this->assertEquals(1, $transaction->getVersion());
        $this->assertEquals(0, $transaction->getLockTime());
        $this->assertEquals('test_txid_in', $transaction->getVin()[0]->getTx());
        $this->assertEquals('asm 1', $transaction->getVin()[0]->getScriptSig()->getAsm());
        $this->assertEquals('hex 1', $transaction->getVin()[0]->getScriptSig()->getHex());
        $this->assertEquals(123, $transaction->getVin()[0]->getSequence());
        $this->assertEquals(25, $transaction->getVout()[0]->getValue());
        $this->assertEquals(0, $transaction->getVout()[0]->getN());
        $this->assertEquals('asm 2', $transaction->getVout()[0]->getScriptPubKey()->getAsm());
        $this->assertEquals('hex 2', $transaction->getVout()[0]->getScriptPubKey()->getHex());
        $this->assertEquals(1, $transaction->getVout()[0]->getScriptPubKey()->getRequiredSignatures());
        $this->assertEquals('pubkeyhash', $transaction->getVout()[0]->getScriptPubKey()->getType());
        $this->assertEquals(['address_1'], $transaction->getVout()[0]->getScriptPubKey()->getAddresses());
    }

    public function createRawTransactionTest()
    {
        $this->mockClient('createrawtransaction', [
            'first_param',
            'second_param'
        ], 'trans_id');

        $creator = m::mock(new RawTransactionBuilder());
        $creator->shouldReceive('getFirstPram')->andReturn('first_param')->once();
        $creator->shouldReceive('getSecondParam')->andReturn('second_param')->once();
        $factory = m::mock(new RawTransactionBuilderFactory());
        $factory->shouldReceive('create')->andReturn($creator);

        $this->assertEquals('trans_id', $this->manager->createRawTransaction($creator));
    }

    public function testAddMultiSigAddress()
    {
        $this->mockClient('addmultisigaddress', [2, '\'["key_1", "key_2"]\'', 'account_name'], 'the_address', 1);
        $this->assertEquals('the_address', $this->manager->addMultiSigAccount(2, ['key_1', 'key_2'], 'account_name'));

    }

    public function testGetNewAddress()
    {
        $this->mockClient('getnewaddress', ['account_name'], $address1 = 'new_address', 1);
        $this->mockClient('getnewaddress', ['account_name'], $address2 = 'new_address2', 1);

        $this->assertEquals($address1, $this->manager->getNewAddress('account_name'));
        $this->assertEquals($address2, $this->manager->getNewAddress('account_name'));
    }

    public function testValidateAddress()
    {
        $this->mockClient('validateaddress', ['test_address'], $this->getResponse('validate_address_valid'), 1);
        $result = $this->manager->validateAddress('test_address');
        $this->assertInstanceOf('Bml\CoinBundle\Entity\ValidationResult', $result);
        $this->assertTrue($result->isValid());
        $this->assertTrue($result->isMine());
        $this->assertFalse($result->isScript());
        $this->assertEquals('the_pub_key', $result->getPublicKey());
        $this->assertEquals('the_account', $result->getAccountName());
        $this->assertEquals('the_address', $result->getAddress());
    }

    /**
     * @param $method
     * @param array $params
     * @param $return
     * @param null $times
     * @return m\Expectation
     */
    private function mockClient($method, $params = [], $return, $times = null)
    {
        $mock = $this->client->shouldReceive('request');
        if (!empty($params)) {
            $mock->with($method, $params)->andReturn($return);
        } else {
            $mock->with($method)->andReturn($return);
        }
        if ($times) {
            $mock->times($times);
        }
        return $times;
    }

    /**
     * @param string $file
     * @param bool $wrapInResultField
     * @return string
     */
    private function getResponse($file, $wrapInResultField = true)
    {
        $result = file_get_contents(__DIR__ . '/responses/' . $file . '.json');
        if ($wrapInResultField) {
            return '{"result": ' . $result . '}';
        } else {
            return $result;
        }
    }
}
