<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class Info extends AbstractEntity
{
    /**
     * @var int
     */
    protected $version;

    /**
     * @var int
     */
    protected $protocolVersion;

    /**
     * @var int
     */
    protected $walletVersion;

    /**
     * @var int
     */
    protected $blocksCount;

    /**
     * @var int
     */
    protected $timeOffset;

    /**
     * @var int
     */
    protected $connectionsCount;

    /**
     * @var string
     */
    protected $proxy;

    /**
     * @var double
     */
    protected $difficulty;

    /**
     * @var bool
     */
    protected $testNet;

    /**
     * @var int
     */
    protected $keyPoolOldest;

    /**
     * @var int
     */
    protected $keyPoolSize;

    /**
     * @var double
     */
    protected $payTxFee;

    /**
     * @var string
     */
    protected $errors;

    /**
     * @var double
     */
    protected $balance;

    /**
     * @var bool
     */
    protected $unlockedUntil;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $customFields = [
            'protocolversion' => 'protocolVersion',
            'walletversion' => 'walletVersion',
            'timeoffset' => 'timeOffset',
            'keypoololdest' => 'keyPoolOldest',
            'keypoolsize' => 'keyPoolSize',
            'paytxfee' => 'payTxFee',
            'blocks' => 'blocksCount',
            'connections' => 'connectionsCount',
            'testnet' => 'testNet',
            'unlocked_until' => 'unlockedUntil'
        ];
        parent::__construct($data, $customFields);
    }

    /**
     * @return float
     */
    public function getPayTxFee()
    {
        return $this->payTxFee;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return int
     */
    public function getBlocksCount()
    {
        return $this->blocksCount;
    }

    /**
     * @return int
     */
    public function getConnectionsCount()
    {
        return $this->connectionsCount;
    }

    /**
     * @return float
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @return string
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return int
     */
    public function getKeyPoolOldest()
    {
        return $this->keyPoolOldest;
    }

    /**
     * @return int
     */
    public function getKeyPoolSize()
    {
        return $this->keyPoolSize;
    }

    /**
     * @return int
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @return boolean
     */
    public function getTestNet()
    {
        return $this->testNet;
    }

    /**
     * @return int
     */
    public function getTimeOffset()
    {
        return $this->timeOffset;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return int
     */
    public function getWalletVersion()
    {
        return $this->walletVersion;
    }

    /**
     * @return boolean
     */
    public function getUnlockedUntil()
    {
        return $this->unlockedUntil;
    }

    /**
     * @param boolean $unlockedUntil
     */
    public function setUnlockedUntil($unlockedUntil)
    {
        $this->unlockedUntil = $unlockedUntil;
    }


}
