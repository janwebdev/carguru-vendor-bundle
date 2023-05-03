<?php

namespace Carguru\VendorBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader as ConfigYamlFileLoader;
class VendorExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new ConfigYamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('settings.yaml');
    }

    /**
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function prepend(ContainerBuilder $container): void
    {
        $loader = new ConfigYamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('doctrine.yaml');
    }
}