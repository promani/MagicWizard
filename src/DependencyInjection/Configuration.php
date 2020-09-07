<?php

namespace MagicWizardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('magic_wizard');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('color')->defaultNull()->end()
                ->scalarNode('company_name')->defaultNull()->end()
                ->scalarNode('logo_url')->defaultNull()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
