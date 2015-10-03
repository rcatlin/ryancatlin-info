<?php

namespace RCatlin\Blog\Behavior;

use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Http\Response;

trait RenderResponse
{
    public function renderResult(Response $response, array $result)
    {
        $response->setStatusCode(200);
        $response->setResult(
            ResourceFactory::result($result)
        );

        return $response;
    }
}
