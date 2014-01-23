<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class Vout extends AbstractEntity
{
    /**
     * @var float
     */
    protected $value;

    /**
     * @var int
     */
    protected $n;

    /**
     * @var ScriptPubKey
     */
    protected $scriptPubKey;

    /**
     * @param array $data
     * @param array $customFields
     */
    function __construct(array $data, $customFields = [])
    {
        $this->scriptPubKey = new ScriptPubKey($data['scriptPubKey']);
        unset($data['scriptPubKey']);
        parent::__construct($data, $customFields);
    }

    /**
     * @return int
     */
    public function getN()
    {
        return $this->n;
    }

    /**
     * @return \Bml\CoinBundle\Entity\ScriptPubKey
     */
    public function getScriptPubKey()
    {
        return $this->scriptPubKey;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }


} 