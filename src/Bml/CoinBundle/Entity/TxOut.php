<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class TxOut extends Vout
{
    /**
     * @var string
     */
    protected $bestBlock;

    /**
     * @var int
     */
    protected $confirmations;

    /**
     * @var float
     */
    protected $version;

    /**
     * @var bool
     */
    protected $coinBase;


    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $customFields = ['bestblock' => 'bestBlock', 'coinbase' => 'coinBase'];
        parent::__construct($data, $customFields);
    }

    /**
     * @return string
     */
    public function getBestBlock()
    {
        return $this->bestBlock;
    }

    /**
     * @return boolean
     */
    public function getCoinBase()
    {
        return $this->coinBase;
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
    public function getVersion()
    {
        return $this->version;
    }



}
