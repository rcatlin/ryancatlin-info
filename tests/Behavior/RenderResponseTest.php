<?php

namespace RCatlin\Blog\Tests\Behavior;

use Refinery29\Piston\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RenderResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testRenderResult()
    {
        $responseStub = new RenderResponseStub();

        $response = new Response(new SymfonyResponse());
        $data = ['the-result'];

        $result = $responseStub->renderResult($response, $data);

        $this->assertInstanceOf(Response::class, $result);
        $this->assertSame('{"result":["the-result"]}', $result->getContent());
    }
}
