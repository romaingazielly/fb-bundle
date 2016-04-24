<?php

namespace Wise\FacebookQuizBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wise_facebook_quiz');

        $this->addQuestionsConfigurationSection($rootNode);

        $rootNode
            ->children()
                ->scalarNode('count')->end()
                ->scalarNode('minimal_score')->end()
                ->arrayNode('database')
                    ->children()
                        ->scalarNode('table_name')->end()
                        ->scalarNode('serialization_handler')
                            ->defaultValue('wise_facebook_quiz.default_serialization_handler')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    protected function addQuestionsConfigurationSection($rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode('source')
                    ->validate()
                        ->ifNotInArray(array('config', 'database'))
                        ->thenInvalid('Invalid quiz source "%s"')
                    ->end()
                    ->isRequired()->defaultValue('config')
                ->end()
                ->arrayNode('questions')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('question')->end()
                            ->arrayNode('answers')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('answer')->end()
                                        ->scalarNode('clue')->end()
                                        ->booleanNode('right')->defaultFalse()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
