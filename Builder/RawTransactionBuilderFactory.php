<?php


namespace Bml\CoinBundle\Builder;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Creator
 */
class RawTransactionBuilderFactory
{
    /**
     * @return RawTransactionBuilder
     */
    public function create()
    {
        return new RawTransactionBuilder();
    }
} 