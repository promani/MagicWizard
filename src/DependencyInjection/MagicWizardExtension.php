<?php

namespace MagicWizardBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MagicWizardExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig('magic_wizard');
        $config = $this->processConfiguration(new Configuration(), $configs);
        $twigGlobals = [
            'globals' => [
                'mw' => $config,
            ],
        ];
        $container->prependExtensionConfig('twig', $twigGlobals);
    }

    public function load(array $configs, ContainerBuilder $container)
    {
    }
}
