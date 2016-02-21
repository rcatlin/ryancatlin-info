<?php

namespace RCatlin\Api\Behavior;

use Assert\Assertion;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\ApiResponse;
use Teapot\StatusCode;

trait RenderResponse
{
    /**
     * @param ApiResponse $response
     * @param array    $result
     * @param int      $status
     *
     * @return ApiResponse
     */
    public function renderResult(ApiResponse $response, array $result, $status = StatusCode::OK)
    {
        Assertion::integer($status);

        $response->setResult(
            ResourceFactory::result($result)
        );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status)
        ;
    }
}
