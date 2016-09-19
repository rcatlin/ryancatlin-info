<?php

namespace RCatlin\Api\Behavior;

use Assert\Assertion;

trait RequiresKeys
{
    public static function requireKeys(array $keys, array $data)
    {
        Assertion::allString($keys);

        $missing = array_diff($keys, array_keys($data));

        if (!empty($missing)) {
            throw new \Exception('Missing required keys: ' . implode(', ', $missing));
        }
    }
}
