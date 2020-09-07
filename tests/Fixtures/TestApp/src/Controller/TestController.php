<?php

namespace TestApp\Controller;

use MagicWizardBundle\Controller\AbstractStepController;
use Symfony\Component\Routing\Annotation\Route;
use TestApp\Flow\TestFlow;

/**
 * @Route("/test", name="test_")
 */
class TestController extends AbstractStepController
{
	public static function getFlowClass(): string
	{
		return TestFlow::class;
	}
}
