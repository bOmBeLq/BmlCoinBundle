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
    private $input = [];

    /**
     * @var array
     */
    private $output = [];

    /**
     * @param string $txid
     * @param int $vout
     */
    public function addInput($txid, $vout)
    {
        $this->input[] = ['txid' => $txid, 'vout' => $vout];
    }

    /**
     * @param $address
     * @param $amount
     */
    public function addOutput($address, $amount)
    {
        $this->output[$address] = $amount;
    }

    /**
     * @return array
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return $this->output;
    }
}
