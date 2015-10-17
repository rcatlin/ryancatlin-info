<?php

namespace RCatlin\Blog\Test\Unit\Behavior;

use RCatlin\Blog\Test\Unit\ReadsResponseContent;
use Refinery29\Piston\Response;

class RenderResponseTest extends \PHPUnit_Framework_TestCase
{
    use ReadsResponseContent;

    public function testRenderResult()
    {
        $responseStub = new RenderResponseStub();

        $data = ['the-result'];

        $response = $responseStub->renderResult(new Response(), $data);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(
            json_encode([
                'result' => $data,
            ]),
            $this->readResponseContent($response)
        );
    }
}
