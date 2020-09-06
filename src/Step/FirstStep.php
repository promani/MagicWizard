<?php

namespace MagicWizardBundle\Step;

use MagicWizardBundle\Model\Step;
use MagicWizardBundle\Form\Step1Type;

class FirstStep extends Step
{
	public $title = 'First step';
	public $subtitle = 'subtitle';

	public function getFormType()
	{
		return Step1Type::class;
	}
}
