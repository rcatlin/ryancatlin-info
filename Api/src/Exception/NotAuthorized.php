<?php

namespace RCatlin\Api\Exception;

class NotAuthorized extends \Exception
{
    public function __construct($message = 'Not Authorized')
    {
        parent::__construct($message);
    }
}
