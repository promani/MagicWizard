<?php

namespace Promani\MagicWizardBundle\Model;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

abstract class Step
{
	/**  @var string */
    protected $title = '';
	/**  @var string */
	protected $subtitle = '';
	/**  @var string */
	protected $description = '';
	/**  @var string|null */
	protected $template = null;
	/**  @var Step|null */
	protected $nextStep;

    abstract public function getFormType();

	public function getProps(): array
	{
		return [
			'title' => $this->title,
			'subtitle' => $this->subtitle,
			'description' => $this->description,
		];
	}

	public function getCondition(): string
	{
		return "1==1";
	}

	public function getNextStep()
	{
		$expressionLanguage = new ExpressionLanguage();
		if ($expressionLanguage->evaluate($this->getCondition())) {
			$this->nextStep;
		}
		return null;
	}

	public function getCallback()
	{
		return null;
	}

	public function getTemplate()
	{
		return $this->template;
	}
}
