<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class TransactionDetails  extends AbstractEntity {

    const CATEGORY_RECEIVE = 'receive';
    const CATEGORY_SEND = 'send';
    const CATEGORY_ORPHAN = 'orphan';


    /**
     * @var float
     */
    protected $amount;

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
    protected $fee;


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
    public function getCategory()
    {
        return $this->category;
    }


}