<?php

namespace RCatlin\Blog\Behavior;

use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Response;

trait RenderResponse
{
    /**
     * @param Response $response
     * @param array    $result
     *
     * @return Response
     */
    public function renderResult(Response $response, array $result)
    {
        $response->setStatusCode(200);
        $response->setResult(
            ResourceFactory::result($result)
        );

        return $response->withHeader('Content-Type', 'application/json');
    }
}
