<?php

namespace RCatlin\Blog\Test;

use Refinery29\Piston\Response;

trait ReadsResponseContent
{
    /**
     * @param Response $response
     *
     * @return string
     */
    public function readResponseContent(Response $response)
    {
        $stream = $response->compileContent();

        $stream->rewind();

        return $stream->getContents();
    }
}
