<?php

namespace RCatlin\Api\Controller\Api;

use RCatlin\Api\Behavior\RenderResponse;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class StatusController
{
    use RenderResponse;

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $vars
     *
     * @return Response
     */
    public function get(Request $request, Response $response, array $vars = [])
    {
        return $this->renderResult($response, ['status' => 'ok']);
    }
}
