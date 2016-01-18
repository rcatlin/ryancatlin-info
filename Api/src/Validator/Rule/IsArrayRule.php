<?php

namespace RCatlin\Blog\Validator\Rule;

use Particle\Validator\Rule;

class IsArrayRule extends Rule
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function validate($value)
    {
        return is_array($value);
    }

    /**
     * @return array
     */
    protected function getMessageParameters()
    {
        return array_merge(self::getMessageParameters(),
            'Value must be an array.'
        );
    }
}
