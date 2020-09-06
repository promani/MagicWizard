<?php

namespace Promani\MagicWizardBundle\Resources\config;

use Promani\MagicWizardBundle\Controller\AbstractStepController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $configurator) {
	$services = $configurator->services()
		->defaults()
		->autowire()
		->autoconfigure()
	;

	$services->set(AbstractStepController::class)
		->autowire();
};
