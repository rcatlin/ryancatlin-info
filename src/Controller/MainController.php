<?php

namespace RCatlin\Blog\Controller;

use RCatlin\Blog\Behavior\RenderResponse;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Router\Routes\Routeable;

/**
 * Class MainController
 * @package RCatlin\Blog\Controller
 */
class MainController implements Routeable
{
    use RenderResponse;

    /**
     * @param  Request  $request
     * @param  Response $response
     * @param  array    $vars
     * @return Response
     */
    public function index(Request $request, Response $response, array $vars = [])
    {
        return $this->renderResult($response, [
            'message' => 'Hello, world.'
        ]);
    }
}
