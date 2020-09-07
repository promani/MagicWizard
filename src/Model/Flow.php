<?php

namespace MagicWizardBundle\Model;

abstract class Flow
{
    /** @return Step[] */
    abstract public function getSteps(): array;

    public function getNextSteps(Step $last = null): ?Step
    {
        $steps = $this->getSteps();
        if ($last) {
            foreach ($steps as $key => $value) {
                if ($last == $value && array_key_exists($key + 1, $steps)) {
                    return $steps[$key + 1];
                }
            }
        } else {
            return $steps[0];
        }
        return null;
    }

    public function getPrevSteps($last = null): ?Step
    {
        $steps = $this->getSteps();
        if ($last) {
            foreach ($steps as $key => $value) {
                if ($last == $value && array_key_exists($key - 1, $steps)) {
                    return $steps[$key - 1];
                }
            }
        }
        return null;
    }
}
