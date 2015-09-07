<?php

namespace RCatlin\Blog\Tests\Validator\Exception;

use RCatlin\Blog\Validator\Exception\InvalidContextException;

class InvalidContextExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException RCatlin\Blog\Validator\Exception\InvalidContextException
     * @expectedExceptionMessage Invalid Validator Context
     *
     * @throws InvalidContextException
     */
    public function testCanThrowException()
    {
        throw new InvalidContextException;
    }
}
