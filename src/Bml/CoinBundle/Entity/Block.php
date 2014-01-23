<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class Block extends AbstractEntity
{
    /**
     * @var string
     */
    protected $hash;

    /**
     * @var int
     */
    protected $confirmations;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var int
     */
    protected $number;

    /**
     * @var int
     */
    protected $version;

    /**
     * @var string
     */
    protected $merkleroot;

    /**
     * @var array
     */
    protected $tx;

    /**
     * @var int
     */
    protected $time;

    /**
     * @var int
     */
    protected $nonce;

    /**
     * @var string
     */
    protected $bits;

    /**
     * @var double
     */
    protected $difficulty;

    /**
     * @var string
     */
    protected $previousBlockHash;

    /**
     * @var
     */
    protected $nextBlockHash;

    /**
     * @param array $data
     */
    function __construct(array $data)
    {
        $customFields = [
            'previousblockhash' => 'previousBlockHash',
            'nextblockhash' => 'nextBlockHash',
            'height' => 'number'
        ];
        parent::__construct($data, $customFields);
    }

    /**
     * @return string
     */
    public function getBits()
    {
        return $this->bits;
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
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getMerkleroot()
    {
        return $this->merkleroot;
    }

    /**
     * @return mixed
     */
    public function getNextBlockHash()
    {
        return $this->nextBlockHash;
    }

    /**
     * @return int
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * @return string
     */
    public function getPreviousBlockHash()
    {
        return $this->previousBlockHash;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return array
     */
    public function getTx()
    {
        return $this->tx;
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
    public function getNumber()
    {
        return $this->number;
    }


} 