<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use TestApp\Controller\TestController;

return static function (ContainerConfigurator $configurator) {
	$services = $configurator->services()
		->defaults()
		->autowire()
		->autoconfigure()
	;

	$services->set(TestController::class)
		->autowire();
};
