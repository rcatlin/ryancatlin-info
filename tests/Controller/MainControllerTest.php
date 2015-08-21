<?php

namespace RCatlin\Blog\Tests\Controller;

use RCatlin\Blog\Controller\MainController;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;

class MainControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        $controller = new MainController();

        $response = $controller->index(new Request(), new Response());

        $this->assertSame('Hello, world.', $response->getContent());
    }
}
