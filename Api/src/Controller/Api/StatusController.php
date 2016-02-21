<?php

namespace RCatlin\Api\Controller\Api;

use RCatlin\Api\Behavior\RenderResponse;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;

class StatusController
{
    use RenderResponse;

    /**
     * @param Request  $request
     * @param ApiResponse $response
     * @param array    $vars
     *
     * @return ApiResponse
     */
    public function get(Request $request, ApiResponse $response, array $vars = [])
    {
        return $this->renderResult($response, ['status' => 'ok']);
    }
}
