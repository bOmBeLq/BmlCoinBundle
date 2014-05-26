<?php

namespace Bml\CoinBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BmlCoinExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        foreach ($config['coins'] as $name => $rpcConfig) {
            // create rpc_client
            $arguments = [];
            $arguments[] = $rpcConfig['rpc_user'];
            $arguments[] = $rpcConfig['rpc_password'];
            $arguments[] = $rpcConfig['rpc_host'];
            $arguments[] = $rpcConfig['rpc_port'];
            $arguments[] = isset($rpcConfig['rpc_path']) ? $rpcConfig['rpc_path'] : '';
            $arguments[] = isset($rpcConfig['rpc_protocol']) ? $rpcConfig['rpc_protocol'] : 'http';
            $arguments[] = isset($rpcConfig['max_retries']) ? $rpcConfig['max_retries'] : 30;
            $arguments[] = isset($rpcConfig['retry_sleep']) ? $rpcConfig['retry_sleep'] : 1;

            $definition = new Definition('Bml\CoinBundle\Client\CurlClient', $arguments);
            $container->setDefinition('bml_coin.' . $name . '.rpc_client', $definition);

            $arguments = [$definition];

            // create manager
            $definition = new Definition('Bml\CoinBundle\Manager\CoinManager', $arguments);
            $container->setDefinition('bml_coin.' . $name . '.manager', $definition);
        }
    }
}
