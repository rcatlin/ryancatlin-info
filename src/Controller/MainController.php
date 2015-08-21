<?php

namespace RCatlin\Blog\Controller;

use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Router\Routes\Routeable;

/**
 * Class MainController
 * @package RCatlin\Blog\Controller
 */
class MainController implements Routeable
{
    /**
     * @param  Request  $request
     * @param  Response $response
     * @param  array    $vars
     * @return Response
     */
    public function index(Request $request, Response $response, array $vars = [])
    {
        $response->setContent("Hello, world.");

        return $response;
    }
}
