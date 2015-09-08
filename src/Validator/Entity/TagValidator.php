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

    /**
     * @param bool|false $allowEmpty
     * @param bool|true $required
     *
     * @return $this
     */
    protected function addId($allowEmpty = false, $required = true)
    {
        return $this->getChain('id', null, $required, $allowEmpty)
            ->numeric()
        ;
    }

    /**
     * @param bool|false $allowEmpty
     * @param bool|true $required
     *
     * @return $this
     */
    protected function addName($allowEmpty = false, $required = true)
    {
        return $this->getChain('name', null, $required, $allowEmpty)
            ->isString()
        ;
    }
}
