<?php

namespace TestApp\Step;

use MagicWizardBundle\Model\RestApiStep;
use TestApp\Form\Step2Type;

class SecondStep extends RestApiStep
{
	public $title = 'Second step';
	public $description = 'description';
	public $method = 'POST';
	public $endpoint = 'description';

	public function getFormType()
	{
		return Step2Type::class;
	}
}
