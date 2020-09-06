<?php

namespace TestApp\Flow;

use MagicWizardBundle\Model\Flow;
use TestApp\Step\FirstStep;
use TestApp\Step\SecondStep;

class TestFlow extends Flow
{
	public function getSteps(): array
	{
		return [
			new FirstStep(),
			new SecondStep(),
		];
	}

}
