<?php

namespace RCatlin\Api\Test\Unit\Validator\Exception;

use RCatlin\Api\Validator\Exception\InvalidContextException;

class InvalidContextExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException RCatlin\Api\Validator\Exception\InvalidContextException
     *
     * @throws InvalidContextException
     */
    public function testCanThrowException()
    {
        throw new InvalidContextException();
    }
}
