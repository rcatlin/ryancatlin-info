<?php

namespace RCatlin\Api\Validator;

use Assert\Assertion;
use Particle\Validator\Chain;
use Particle\Validator\Validator;

class CustomChain extends Chain
{
    /**
     * @return $this
     */
    public function isArray()
    {
        return $this->addRule(new Rule\IsArrayRule());
    }

    /**
     * @return $this
     */
    public function isString()
    {
        return $this->addRule(new Rule\IsStringRule());
    }

    /**
     * @param Validator $validator
     * @param $context
     * @param $allowEmpty
     * 
     * @return $this
     */
    public function embed(Validator $validator, $allowEmpty = false, $context = AbstractValidator::DEFAULT_CONTEXT)
    {
        Assertion::string($context);
        Assertion::boolean($allowEmpty);

        return $this->addRule(new Rule\EmbeddedValidatorRule($validator, $context, $allowEmpty));
    }

    /**
     * @param Validator $validator
     * @param $context
     * @param $allowEmpty
     *
     * @return $this
     */
    public function embedArray(Validator $validator, $allowEmpty = false, $context = AbstractValidator::DEFAULT_CONTEXT)
    {
        Assertion::string($context);
        Assertion::boolean($allowEmpty);

        return $this->addRule(
            new Rule\EmbeddedArrayValidatorRule($validator, $context = AbstractValidator::DEFAULT_CONTEXT, $allowEmpty)
        );
    }
}
