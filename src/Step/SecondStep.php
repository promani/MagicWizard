<?php

namespace Promani\MagicWizardBundle\Step;

use Promani\MagicWizardBundle\Model\Step;
use Promani\MagicWizardBundle\Form\Step2Type;

class SecondStep extends Step
{
	public $title = 'Second step';
	public $description = 'description';

	public function getFormType()
	{
		return Step2Type::class;
	}
}
