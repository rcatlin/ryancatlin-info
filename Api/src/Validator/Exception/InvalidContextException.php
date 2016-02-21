<?php

namespace RCatlin\Api\Validator\Exception;

class InvalidContextException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Invalid Validator Context';
}
