<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class ValidationResult extends AbstractEntity
{

    /**
     * @var bool
     */
    protected $isValid;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $addresses;

    /**
     * @var bool
     */
    protected $isMine;

    /**
     * @var bool
     */
    protected $isScript;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @var bool
     */
    protected $isCompressed;

    /**
     * @var string
     */
    protected $accountName;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $customFields = [
            'isvalid' => 'isValid',
            'ismine' => 'isMine',
            'isscript' => 'isScript',
            'iscompressed' => 'isCompressed',
            'pubkey' => 'publicKey',
            'account' => 'accountName'
        ];
        parent::__construct($data, $customFields);
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @return boolean
     */
    public function isCompressed()
    {
        return $this->isCompressed;
    }

    /**
     * @return boolean
     */
    public function isMine()
    {
        return $this->isMine;
    }

    /**
     * @return boolean
     */
    public function isScript()
    {
        return $this->isScript;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @param string $addresses
     * @return $this
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddresses()
    {
        return $this->addresses;
    }


}
