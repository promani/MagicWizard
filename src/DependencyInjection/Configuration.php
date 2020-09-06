<?php

namespace Promani\MagicWizardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder('magic_wizard');

		$treeBuilder->getRootNode()
			->children()
				->scalarNode('color')->defaultValue('#FF5733')->end()
			->end()
		;

		return $treeBuilder;
	}
}
