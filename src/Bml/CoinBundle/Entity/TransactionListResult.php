<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class TransactionListResult extends AbstractEntity
{
    const CATEGORY_RECEIVE = 'receive';
    const CATEGORY_SEND = 'send';
    const CATEGORY_ORPHAN = 'orphan';

    /**
     * @var String
     */
    protected $account;


    /**
     * @var String
     */
    protected $address;

    /**
     * @var String
     */
    protected $category;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var float
     */
    protected $fee;

    /**
     * @var int
     */
    protected $confirmations;

    /**
     * @var String
     */
    protected $blockHash;

    /**
     * @var int
     */
    protected $blockIndex;

    /**
     * @var \DateTime
     */
    protected $blockTime;

    /**
     * @var string
     */
    protected $txId;

    /**
     * @var \DateTime
     */
    protected $time;

    /**
     * @var \DateTime
     */
    protected $timeReceived;
    /**
     * @var string
     */
    protected $otherAccount;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var bool
     */
    protected $generated;

    /**
     * @var array
     */
    protected $walletConflicts;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        if (isset($data['blocktime'])) {
            $this->blockTime = new \DateTime('@' . $data['blocktime']);
            unset($data['blocktime']);
        }
        if (isset($data['time'])) {
            $this->time = new \DateTime('@' . $data['time']);
            unset($data['time']);
        }
        if (isset($data['timereceived'])) {
            $this->timeReceived = new \DateTime('@' . $data['timereceived']);
            unset($data['timereceived']);
        }
        parent::__construct($data, [
            'blockindex' => 'blockIndex',
            'blockhash' => 'blockHash',
            'txid' => 'txId',
            'otheraccount' => 'otherAccount',
            'walletconflicts' => 'walletConflicts'
        ]);
    }

    /**
     * @return String
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return String
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return String
     */
    public function getBlockHash()
    {
        return $this->blockHash;
    }

    /**
     * @return int
     */
    public function getBlockIndex()
    {
        return $this->blockIndex;
    }

    /**
     * @return \DateTime
     */
    public function getBlockTime()
    {
        return $this->blockTime;
    }

    /**
     * @return String
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getConfirmations()
    {
        return $this->confirmations;
    }

    /**
     * @return float
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * @return boolean
     */
    public function getGenerated()
    {
        return $this->generated;
    }

    /**
     * @return string
     */
    public function getOtherAccount()
    {
        return $this->otherAccount;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return \DateTime
     */
    public function getTimeReceived()
    {
        return $this->timeReceived;
    }

    /**
     * @return string
     */
    public function getTxId()
    {
        return $this->txId;
    }


}
