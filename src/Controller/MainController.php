<?php

namespace RCatlin\Blog\Controller;

use RCatlin\Blog\Behavior\RenderResponse;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class MainController
{
    use RenderResponse;

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $vars
     *
     * @return Response
     */
    public function index(Request $request, Response $response, array $vars = [])
    {
        return $this->renderResult($response, [
            'message' => 'Hello, world.',
        ]);
    }
}
