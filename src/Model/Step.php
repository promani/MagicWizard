<?php

namespace MagicWizardBundle\Model;

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
    /**  @var string|null */
    protected $image = null; //Not implemented yet

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

    public function getNextStep(): ?Step
    {
        return null;
    }

    public function hasToSkip($data): ?Step
    {
        $expressionLanguage = new ExpressionLanguage();
        if ($expressionLanguage->evaluate($this->getCondition(), ['data' => $data])) {
            $this->getNextStep();
        }
        return null;
    }

    public function isAllowFail(): bool
    {
        return false;
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
