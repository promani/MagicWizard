<?php

namespace TestApp\Step;

use Promani\MagicWizardBundle\Model\Step;
use TestApp\Form\Step1Type;

class FirstStep extends Step
{
	public $title = 'First step';
	public $subtitle = 'subtitle';

	public function getFormType()
	{
		return Step1Type::class;
	}
}
