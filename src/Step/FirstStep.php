<?php

namespace MagicWizardBundle\Step;

use MagicWizardBundle\Form\Step1Type;
use MagicWizardBundle\Model\Step;

class FirstStep extends Step
{
    public $title = 'First step';
    public $subtitle = 'subtitle';

    public function getFormType()
    {
        return Step1Type::class;
    }
}
