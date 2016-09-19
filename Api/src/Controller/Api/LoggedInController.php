<?php

namespace RCatlin\Api\Controller\Api;

use RCatlin\Api\Behavior\RenderResponse;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;

class LoggedInController
{
    use RenderResponse;

    public function check(Request $request, ApiResponse $response, array $vars = [])
    {
        return $this->renderResult($response, ['foo' => true]);
    }
}
