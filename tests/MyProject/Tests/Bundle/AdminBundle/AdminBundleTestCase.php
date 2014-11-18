<?php

namespace MyProject\Tests\Bundle\AdminBundle;

class AdminBundleTestCase extends \PHPUnit_Framework_TestCase
{
    protected function buildMock($class)
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
