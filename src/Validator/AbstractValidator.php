<?php

namespace RCatlin\Blog\Validator;

use Particle\Validator\Validator;

abstract class AbstractValidator extends Validator
{
    /**
     * @param string $key
     * @param string $name
     * @param bool   $required
     * @param bool   $allowEmpty
     *
     * @return CustomChain
     */
    protected function buildChain($key, $name, $required, $allowEmpty)
    {
        return new CustomChain($key, $name, $required, $allowEmpty);
    }

    /**
     * @param string $key
     * @param string $name
     * @param bool   $required
     * @param bool   $allowEmpty
     *
     * @return CustomChain
     */
    protected function getChain($key, $name, $required, $allowEmpty)
    {
        return parent::getChain($key, $name, $required, $allowEmpty);
    }
}
