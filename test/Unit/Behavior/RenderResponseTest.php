<?php

namespace RCatlin\Blog\Test\Unit\Behavior;

use RCatlin\Blog\Behavior\RenderResponse;
use RCatlin\Blog\Test\Unit\ReadsResponseContent;
use Refinery29\Piston\Response;

class RenderResponseTest extends \PHPUnit_Framework_TestCase
{
    use RenderResponse;
    use ReadsResponseContent;

    public function testRenderResult()
    {
        $data = ['the-result'];

        $response = $this->renderResult(new Response(), $data);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(
            json_encode([
                'result' => $data,
            ]),
            $this->readResponseContent($response)
        );
    }
}
