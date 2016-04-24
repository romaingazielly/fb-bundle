<?php

namespace Wise\FacebookBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wise_facebook');

        $rootNode
            ->children()
                ->booleanNode('simulate_facebook')
                    ->defaultValue(false)
                ->end()
                ->arrayNode('mobile_views')
                    ->prototype('scalar')
                    ->end()
                ->end() 
                ->scalarNode('end_date')->end()
                ->arrayNode('app_info')
                    ->isRequired()
                    ->children()
                        ->scalarNode('id')->isRequired()->end()
                        ->scalarNode('secret')->isRequired()->end()
                        ->scalarNode('desktop_url')->isRequired()->end()
                        ->scalarNode('mobile_url')->end()
                        ->arrayNode('permissions')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('socials')
                    ->children()
                        ->scalarNode('share_url')->end()
                        ->arrayNode('twitter')
                            ->children()
                                ->scalarNode('user')->end()
                                ->scalarNode('message')->end()
                                ->scalarNode('hashtags')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('meta')
                    ->children()
                        ->scalarNode('og_title')->end()
                        ->scalarNode('og_description')->end()
                        ->scalarNode('og_image')->end()
                        ->scalarNode('og_site_name')->end()
                        ->scalarNode('og_type')->end()
                    ->end()
                ->end()
            ->end()
        ;

        $this->addStatsConfigurationSection($rootNode);
        $this->addSocialsConfigurationSection($rootNode);

        return $treeBuilder;
    }

    protected function addStatsConfigurationSection($root)
    {
        $root
            ->children()
                ->arrayNode('stats')
                    ->canBeEnabled()
                    ->children()
                        ->arrayNode('record')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    protected function addSocialsConfigurationSection($root)
    {
        $root
            ->children()
                ->arrayNode('socials')
                    ->canBeEnabled()
                    ->children()
                        ->arrayNode('twitter')
                            ->children()
                                ->scalarNode('message')->defaultValue('')->end()
                                ->scalarNode('url')->defaultValue('')->end()
                            ->end()
                        ->end()
                        ->arrayNode('facebook')
                            ->children()
                                ->scalarNode('message')->defaultValue('')->end()
                                ->scalarNode('url')->defaultValue('')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

    }
}
