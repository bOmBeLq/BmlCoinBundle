<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Coin
 */
class Account
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $balance;

    /**
     * @param $name
     * @param $balance
     */
    function __construct($name, $balance)
    {
        $this->balance = $balance;
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}