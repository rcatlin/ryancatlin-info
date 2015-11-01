<?php

namespace RCatlin\Blog\Behavior;

use Assert\Assertion;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Response;

trait RenderResponse
{
    /**
     * @param Response $response
     * @param array    $result
     * @param int      $status
     *
     * @return Response
     */
    public function renderResult(Response $response, array $result, $status = 200)
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
