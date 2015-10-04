<?php

namespace RCatlin\Blog\Test\Unit\Controller;

use RCatlin\Blog\Controller\MainController;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MainControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testIndex()
    {
        $controller = new MainController();

        $response = $controller->index(
            new Request(),
            new Response(
                new SymfonyResponse()
            )
        );

        $this->assertSame('{"result":{"message":"Hello, world."}}', $response->getContent());
    }
}
