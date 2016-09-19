<?php

namespace RCatlin\Api\Exception;

class NotAuthorized extends \Exception
{
    public function __construct()
    {
        parent::__construct('Not Authorized');
    }
}
