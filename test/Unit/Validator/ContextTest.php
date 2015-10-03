<?php

namespace RCatlin\Blog\Test\Unit\Validator;

use RCatlin\Blog\Validator\Context;

class ContextTest extends \PHPUnit_Framework_TestCase
{
    public function testContextsExist()
    {
        $this->assertNotEmpty(Context::CREATE);
        $this->assertNotEmpty(Context::UPDATE);
    }
}
