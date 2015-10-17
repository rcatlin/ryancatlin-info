<?php

namespace RCatlin\Blog\Validator;

use Particle\Validator\Chain;

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
}
