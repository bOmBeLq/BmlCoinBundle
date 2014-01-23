<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class Vin extends AbstractEntity
{

    /**
     * @var string
     */
    protected $tx;

    /**
     * @var int
     */
    protected $vout;

    /**
     * @var ScriptSig
     */
    protected $scriptSig;

    /**
     * @var int
     */
    protected $sequence;

    /**
     * @var int
     */
    protected $coinBase;

    /**
     * @param array $data
     */
    function __construct(array $data)
    {
        if (isset($data['scriptSig'])) {
            $this->scriptSig = new ScriptSig($data['scriptSig']);
            unset($data['scriptSig']);
        }
        $custom = ['coinbase' => 'coinBase', 'txid' => 'tx'];
        parent::__construct($data, $custom);
    }


    /**
     * @return \Bml\CoinBundle\Entity\ScriptSig
     */
    public function getScriptSig()
    {
        return $this->scriptSig;
    }

    /**
     * @return int
     */
    public function getSequence()
    {
        return $this->sequence;
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
    public function getVout()
    {
        return $this->vout;
    }
} 