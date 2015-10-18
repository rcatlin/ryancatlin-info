<?php

namespace RCatlin\Blog\Validator\Entity;

use RCatlin\Blog\Validator\AbstractValidator;
use RCatlin\Blog\Validator\Context;

class TagValidator extends AbstractValidator
{
    public function __construct()
    {
        parent::__construct();

        $this->context(Context::CREATE, function () {
            $this->addName();
        });

        $this->context(Context::UPDATE, function () {
            $this->addId();
            $this->addName();
        });
    }

    /**
     * @param bool|false $allowEmpty
     * @param bool|true  $required
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
     * @param bool|true  $required
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
