<?php

namespace MyProject\Tests\Bundle\APIBundle;

class APIBundleTestCase extends \PHPUnit_Framework_TestCase
{
    protected function buildMock($class)
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
