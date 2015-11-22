<?php

namespace RCatlin\Blog\Test\Unit\Controller;

use RCatlin\Blog\Controller\MainController;
use RCatlin\Blog\Test\ReadsResponseContent;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class MainControllerTest extends \PHPUnit_Framework_TestCase
{
    use ReadsResponseContent;

    public function testIndex()
    {
        $controller = new MainController();

        $response = $controller->index(new Request(), new Response());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(
            json_encode([
                'result' => [
                    'message' => 'Hello, world.',
                ],
            ]),
            $this->readControllerResponse($response)
        );
    }
}
