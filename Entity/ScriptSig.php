<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class ScriptSig extends AbstractEntity
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


} 