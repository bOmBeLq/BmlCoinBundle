<?php


namespace Bml\CoinBundle\Builder;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Creator
 */
class RawTransactionBuilder
{
    /**
     * @var array
     */
    private $transfers = [];

    /**
     * @var float[]
     */
    private $amountsByAddress = [];

    /**
     * @param string $txid
     * @param string $toAddress
     * @param float $amount
     * @return $this
     */
    public function addTransfer($txid, $toAddress, $amount)
    {
        $this->transfers[] = [$txid, $toAddress];
        if (!isset($this->amountsByAddress[$toAddress])) {
            $this->amountsByAddress[$toAddress] = 0;
        }
        $this->amountsByAddress[$toAddress] += $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstPram()
    {
        $return = '\'[';
        $list = [];

        foreach ($this->transfers as list($txid, $to)) {
            $vout = array_search($to, array_keys($this->amountsByAddress));
            $list[] = '{"txid": "' . $txid . '", "vout": ' . $vout . '}';
        }
        $return .= implode(', ', $list);
        $return .= ']\'';
        return $return;
    }

    /**
     * @return string
     */
    public function getSecondParam()
    {
        $return = '\'';
        $list = [];
        foreach ($this->amountsByAddress as $address => $amount) {
            $list[] = '{"' . $address . '": ' . $amount . '}';
        }
        $return .= implode(', ', $list);
        $return .= '\'';
        return $return;
    }
} 