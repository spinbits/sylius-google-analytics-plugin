<?php

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress UnusedVariable
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('spinbits_sylius_google_analytics4');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('id')->end()
            ->booleanNode('enabled')->defaultTrue()->end()
            ->scalarNode('additionalParameters')->defaultValue('')->end()
            ->scalarNode('templateName')->defaultValue('@SpinbitsSyliusGoogleAnalytics4Plugin/tagmanager_head.html.twig')->end()
            ->end();

        return $treeBuilder;
    }
}
