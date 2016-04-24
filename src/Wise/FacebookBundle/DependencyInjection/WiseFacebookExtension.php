<?php

namespace Wise\FacebookBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class WiseFacebookExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('wise_facebook_simulate',        $config['simulate_facebook']);

        $container->setParameter('wise_facebook_end_date',        isset($config['end_date']) ? $config['end_date'] : null);

        $container->setParameter('wise_facebook_app_id',          $config['app_info']['id']);
        $container->setParameter('wise_facebook_app_secret',      $config['app_info']['secret']);
        $container->setParameter('wise_facebook_app_permissions', $config['app_info']['permissions']);
        $container->setParameter('wise_facebook_app_desktop_url', $config['app_info']['desktop_url']);
        $container->setParameter(
            'wise_facebook_app_mobile_url', 
            array_key_exists('mobile_url', $config['app_info']) ?
                $config['app_info']['mobile_url'] :
                $config['app_info']['desktop_url']
        );
    }
}
