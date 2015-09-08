<?php

namespace RCatlin\Blog\Validator\Rule;

use Particle\Validator\Rule;

class IsStringRule extends Rule
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function validate($value)
    {
        return is_string($value);
    }

    protected function getMessageParameters()
    {
        return array_merge(self::getMessageParameters(),
            'Value must be a string.'
        );
    }
}
