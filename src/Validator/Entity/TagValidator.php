<?php

namespace RCatlin\Blog\Validator\Entity;

use RCatlin\Blog\Validator\AbstractValidator;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Exception\InvalidContextException;

class TagValidator extends AbstractValidator
{

    /**
     * Setup required/optional values.
     */
    protected function setup()
    {
        if ($this->context === Context::CREATE) {
            $this->addName();

            return;
        } elseif ($this->context === Context::UPDATE) {
            $this->addId();
            $this->addName();

            return;
        }

        throw new InvalidContextException;
    }

    protected function addId($allowEmpty = false, $required = true)
    {
        return $this->getChain('id', null, $required, $allowEmpty);
    }

    protected function addName($allowEmpty = false, $required = true)
    {
        return $this->getchain('name', null, $required, $allowEmpty);
    }
}
