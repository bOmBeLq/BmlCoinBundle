<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class ScriptPubKey extends AbstractEntity
{
    /**
     * @var string
     */
    protected $asm;

    /**
     * @var string
     */
    protected $hex;

    /**
     * @var int
     */
    protected $requiredSignatures;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array|string[]
     */
    protected $addresses = [];

    /**
     * @param array $data
     * @param array $customFields
     */
    public function __construct(array $data, $customFields = [])
    {
        $customFields = ['reqSigs' => 'requiredSignatures'];
        parent::__construct($data, $customFields);
    }


    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @return string
     */
    public function getAsm()
    {
        return $this->asm;
    }

    /**
     * @return string
     */
    public function getHex()
    {
        return $this->hex;
    }

    /**
     * @return int
     */
    public function getRequiredSignatures()
    {
        return $this->requiredSignatures;
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


}
