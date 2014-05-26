<?php


namespace Bml\CoinBundle\Manager;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Manager
 */
class CoinManagerContainer extends ContainerAware
{
    /**
     * @param $name
     * @return CoinManager
     * @throws \InvalidArgumentException
     */
    public function get($name)
    {
        $id = 'bml_coin.' . $name . '.manager';
        if (!$this->container->has($id)) {
            throw new \InvalidArgumentException('Coin named "' . $name . '" has not been defined in config');
        }
        return $this->container->get($id);
    }
}
