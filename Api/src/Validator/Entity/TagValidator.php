<?php

namespace RCatlin\Api\Validator\Entity;

use RCatlin\Api\Validator\AbstractValidator;
use RCatlin\Api\Validator\Context;

class TagValidator extends AbstractValidator
{
    public function __construct()
    {
        parent::__construct();

        $this->context(Context::CREATE, function () {
            $this->addName();
        });

        $this->context(Context::UPDATE, function () {
            $this->copyContext(Context::CREATE);
        });

        $this->context(Context::PARTIAL_UPDATE, function () {
            $this->copyContext(Context::CREATE);
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
