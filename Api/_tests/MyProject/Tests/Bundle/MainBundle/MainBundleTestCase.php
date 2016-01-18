<?php

namespace MyProject\Tests\Bundle\MainBundle;

class MainBundleTestCase extends \PHPUnit_Framework_TestCase
{
    protected function buildMock($class)
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }
}
