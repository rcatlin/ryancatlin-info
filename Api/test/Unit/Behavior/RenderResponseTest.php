<?php

namespace RCatlin\Api\Test\Unit\Behavior;

use RCatlin\Api\Behavior\RenderResponse;
use RCatlin\Api\Test\ReadsResponseContent;
use Refinery29\Piston\ApiResponse;

class RenderResponseTest extends \PHPUnit_Framework_TestCase
{
    use RenderResponse;
    use ReadsResponseContent;

    public function testRenderResult()
    {
        $data = ['the-result'];

        $response = $this->renderResult(new ApiResponse(), $data);

        $this->assertInstanceOf(ApiResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(
            json_encode([
                'result' => $data,
            ]),
            $this->readControllerResponse($response)
        );
    }
}
