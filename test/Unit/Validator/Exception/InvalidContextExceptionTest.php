<?php

namespace RCatlin\Blog\Test\Unit\Validator\Exception;

use RCatlin\Blog\Validator\Exception\InvalidContextException;

class InvalidContextExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException RCatlin\Blog\Validator\Exception\InvalidContextException
     *
     * @throws InvalidContextException
     */
    public function testCanThrowException()
    {
        throw new InvalidContextException;
    }
}
