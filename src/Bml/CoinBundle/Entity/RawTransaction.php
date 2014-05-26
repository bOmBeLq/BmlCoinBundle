<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class RawTransaction extends AbstractEntity
{

    /**
     * @var String
     */
    protected $hex;

    /**
     * @var string
     */
    protected $tx;

    /**
     * @var int
     */
    protected $version;

    /**
     * @var \DateTime
     */
    protected $lockTime;

    /**
     * @var Vin[]
     */
    protected $vin = [];

    /**
     * @var Vout[]
     */
    protected $vout = [];

    /**
     * @var string
     */
    protected $blockHash;

    /**
     * @var \DateTime
     */
    protected $blockTime;


    /**
     * @var int
     */
    protected $confirmations;

    /**
     * @var \DateTime
     */
    protected $time;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data['vin'] as $vinData) {
            $this->vin[] = new Vin($vinData);
        }
        unset($data['vin']);

        foreach ($data['vout'] as $voutData) {
            $this->vout[$voutData['n']] = new Vout($voutData);
        }
        unset($data['vout']);


        if (isset($data['blocktime'])) {
            $this->blockTime = \DateTime::createFromFormat('U', $data['blocktime']);
            unset($data['blocktime']);
        }
        if (isset($data['time'])) {
            $this->time = \DateTime::createFromFormat('U', $data['time']);
            unset($data['time']);
        }
        parent::__construct($data, ['locktime' => 'lockTime', 'blockhash' => 'blockHash', 'txid' => 'tx']);
    }

    /**
     * @return String
     */
    public function getHex()
    {
        return $this->hex;
    }

    /**
     * @return int
     */
    public function getLockTime()
    {
        return $this->lockTime;
    }

    /**
     * @return string
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
     * @return \Bml\CoinBundle\Entity\Vin[]
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * @return \Bml\CoinBundle\Entity\Vout[]
     */
    public function getVout()
    {
        return $this->vout;
    }

    /**
     * @return string
     */
    public function getBlockHash()
    {
        return $this->blockHash;
    }

    /**
     * @return int
     */
    public function getConfirmations()
    {
        return $this->confirmations;
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
    public function getBlockTime()
    {
        return $this->blockTime;
    }


}
