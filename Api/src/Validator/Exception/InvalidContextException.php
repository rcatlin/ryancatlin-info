<?php

namespace RCatlin\Blog\Validator\Exception;

class InvalidContextException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Invalid Validator Context';
}
