<?php


namespace Bml\CoinBundle\Manager;

use Bml\CoinBundle\Client\CurlClient;
use Bml\CoinBundle\Builder\RawTransactionBuilder;
use Bml\CoinBundle\Entity\Account;
use Bml\CoinBundle\Entity\Block;
use Bml\CoinBundle\Entity\Info;
use Bml\CoinBundle\Entity\RawTransaction;
use Bml\CoinBundle\Entity\SignRawTransactionResult;
use Bml\CoinBundle\Entity\Transaction;
use Bml\CoinBundle\Entity\TransactionListResult;
use Bml\CoinBundle\Entity\TxOut;
use Bml\CoinBundle\Entity\ValidationResult;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Manager
 */
class CoinManager
{

    /**
     * @var CurlClient
     */
    private $client;

    /**
     * @param CurlClient $client
     */
    public function __construct(CurlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $account
     * @param int $count
     * @param int $from
     * @return array|TransactionListResult[]
     */
    public function listTransactions($account = null, $count = null, $from = null)
    {
        $params = [];
        $account !== null && $params[] = $account;
        $count && $params[] = $count;
        $from && $params[] = $from;

        $results = $this->request('listtransactions', $params);
        $transactions = [];
        foreach ($results as $result) {
            $transactions[] = new TransactionListResult($result);
        }
        return $transactions;
    }

    /**
     * @param string $hex
     * @return mixed
     */
    public function sendRawTransaction($hex)
    {
        return $this->request('sendrawtransaction', [$hex]);
    }

    /**
     * @param $fromAccount
     * @param array $amounts address/amount key/value pair
     * @return PayoutT
     */
    public function sendMany($fromAccount, array $amounts)
    {
        return $this->request('sendmany', [$fromAccount, $amounts]);
    }

    /**
     * @param string $fromAccount
     * @param string $toAddress
     * @param float $amount
     * @param int $minConf
     * @param string $comment
     * @param string $commentTo
     * @return string
     */
    public function sendFrom($fromAccount, $toAddress, $amount, $minConf = null, $comment = null, $commentTo = null)
    {
        $params = [$fromAccount, $toAddress, $amount];
        $minConf !== null && $params[] = $minConf;
        $comment !== null && $params[] = $comment;
        $commentTo !== null && $params[] = $commentTo;

        return $this->request('sendfrom', $params);
    }

    /**
     * @param string $hex
     * @return SignRawTransactionResult
     */
    public function signRawTransaction($hex)
    {
        return new SignRawTransactionResult($this->request('signrawtransaction', [$hex]));
    }

    /**
     * @param $hash
     * @return RawTransaction
     */
    public function decodeRawTransaction($hash)
    {
        return new RawTransaction($this->request('decoderawtransaction', [$hash]));
    }

    /**
     * @param RawTransactionBuilder $creator
     * @return string
     */
    public function createRawTransaction(RawTransactionBuilder $creator)
    {
        return $this->request('createrawtransaction', [$creator->getInput(), $creator->getOutput()]);
    }

    /**
     * @param $requiredSigns
     * @param array $keys
     * @param $account
     * @return string
     */
    public function addMultiSigAccount($requiredSigns, array $keys, $account = null)
    {

        $params = [$requiredSigns, $keys];
        if ($account) {
            $params[] = $account;
        }
        return $this->request('addmultisigaddress', $params);

    }

    /**
     * @param $address
     * @return ValidationResult
     */
    public function validateAddress($address)
    {
        return new ValidationResult($this->request('validateaddress', [$address]));
    }

    /**
     * @return Account[]
     */
    public function getAccounts()
    {
        $response = $this->request('listaccounts');
        $accounts = [];
        foreach ($response as $name => $balance) {
            $accounts[] = new Account($name, $balance);
        }
        return $accounts;
    }

    /**
     * @param string $accountName
     * @return string
     */
    public function getNewAddress($accountName)
    {
        return $this->request('getnewaddress', [$accountName]);
    }

    /**
     * @return int
     */
    public function getBlockCount()
    {
        return $this->request('getblockcount');
    }

    /**
     * @return double
     */
    public function getDifficulty()
    {
        return $this->request('getdifficulty');
    }

    /**
     * @return int
     */
    public function getConnectionCount()
    {
        return $this->request('getconnectioncount');
    }

    /**
     * @param string $account
     * @return string
     */
    public function getAccountAddress($account)
    {
        return $this->request('getaccountaddress', [$account]);
    }

    /**
     * @param string $address
     * @return string
     */
    public function getAccount($address)
    {
        return $this->request('getaccount', [$address]);
    }

    /**
     * @return string
     */
    public function getBestBloc()
    {
        return $this->getBlockByNumber($this->getBlockCount());
    }


    /**
     * @param $account
     * @return string[]
     */
    public function getAddressesByAccount($account)
    {
        return $this->request('getaddressesbyaccount', [$account]);
    }


    /**
     * @param string $account optional
     * @param $minConfirmations
     * @return Block
     */
    public function getBalance($account, $minConfirmations = 1)
    {
        return $this->request('getbalance', [$account, $minConfirmations]);
    }

    /**
     * @param string $hash
     * @return Block
     */
    public function getBlock($hash)
    {
        return new Block($this->request('getblock', [$hash]));
    }

    /**
     * @param int $number
     * @return Block
     */
    public function getBlockByNumber($number)
    {
        return new Block($this->request('getblock', [$this->getBlockHash($number)]));
    }

    /**
     * @param $index
     * @return int
     */
    public function getBlockHash($index)
    {
        return $this->request('getblockhash', [$index]);
    }

    /**
     * @return Info
     */
    public function getInfo()
    {
        return new Info($this->request('getinfo'));
    }

    /**
     * @param $tx
     * @return RawTransaction
     */
    public function getRawTransaction($tx)
    {
        return new RawTransaction($this->request('getrawtransaction', [$tx, 1]));
    }

    /**
     * @param $tx
     * @return Transaction
     */
    public function getTransaction($tx)
    {
        return new Transaction($this->request('gettransaction', [$tx]));
    }

    /**
     * @param $tx
     * @return string
     */
    public function getRawTransactionHex($tx)
    {
        return new RawTransaction($this->request('getrawtransaction', [$tx, 0]));
    }

    /**
     * @param string $tx
     * @param $outNum
     * @return TxOut
     */
    public function getTxOut($tx, $outNum)
    {
        return new TxOut($this->request('gettxout', [$tx, $outNum]));
    }

    /**
     * @return null
     */
    public function keyPoolRefill()
    {
        return $this->request('keypoolrefill');
    }

    /**
     * @param $method
     * @param array $params
     * @return mixed
     */
    private function request($method, $params = [])
    {
        $response = $this->rawRequest($method, $params);
        $responseArr = json_decode($response, true);
        return isset($responseArr['result']) ? $responseArr['result'] : $response;
    }

    /**
     * @param $method
     * @param array $params
     * @return string
     */
    public function rawRequest($method, $params = [])
    {
        if (!empty($params)) {
            return $this->client->request($method, $params);
        } else {
            return $this->client->request($method);
        }
    }
}
