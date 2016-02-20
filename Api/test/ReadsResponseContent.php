<?php

namespace RCatlin\Api\Test;

use Psr\Http\Message\ResponseInterface;
use Refinery29\Piston\Response;

trait ReadsResponseContent
{
    /**
     * @param Response $response
     *
     * @return string
     */
    public function readControllerResponse(Response $response)
    {
        $stream = $response->compileContent();

        $stream->rewind();

        return $stream->getContents();
    }

    /**
     * @param ResponseInterface $response
     *
     * @return string
     */
    public function readResponse(ResponseInterface $response)
    {
        return $response->getBody()->getContents();
    }
}
