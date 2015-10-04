<?php

namespace RCatlin\Blog\test\Unit;

use Assert\Assertion;

trait BuildsMocks
{
    /**
     * @param $className
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function buildMock($className)
    {
        Assertion::string($className);

        return $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock()
            ;
    }
}
