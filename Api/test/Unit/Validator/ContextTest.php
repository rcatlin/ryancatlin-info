<?php

namespace RCatlin\Api\Test\Unit\Validator;

use RCatlin\Api\Validator\Context;

class ContextTest extends \PHPUnit_Framework_TestCase
{
    public function testContextsExist()
    {
        $this->assertNotEmpty(Context::CREATE);
        $this->assertNotEmpty(Context::UPDATE);
    }
}
