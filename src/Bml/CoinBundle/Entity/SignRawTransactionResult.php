<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class SignRawTransactionResult extends AbstractEntity
{

    /**
     * @var string
     */
    protected $hex;

    /**
     * @var bool
     */
    protected $complete;

    /**
     * @return string
     */
    public function getHex()
    {
        return $this->hex;
    }

    /**
     * @return boolean
     */
    public function getComplete()
    {
        return $this->complete;
    }


}
