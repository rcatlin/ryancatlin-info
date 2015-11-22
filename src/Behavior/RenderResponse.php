<?php

namespace RCatlin\Blog\Behavior;

use Assert\Assertion;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Response;
use Teapot\StatusCode;

trait RenderResponse
{
    /**
     * @param Response $response
     * @param array    $result
     * @param int      $status
     *
     * @return Response
     */
    public function renderResult(Response $response, array $result, $status = StatusCode::OK)
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
