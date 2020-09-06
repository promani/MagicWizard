<?php

namespace TestApp\Step;

use MagicWizardBundle\Model\Step;
use TestApp\Form\Step2Type;

class SecondStep extends Step
{
	public $title = 'Second step';
	public $description = 'description';

	public function getFormType()
	{
		return Step2Type::class;
	}
}
