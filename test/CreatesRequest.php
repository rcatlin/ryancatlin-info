<?php

namespace RCatlin\Blog\Test;

use Assert\Assertion;
use Refinery29\Piston\Request;
use Zend\Diactoros\Stream;

trait CreatesRequest
{
    /**
     * @param $content
     *
     * @return Request
     */
    public function createRequest($content)
    {
        Assertion::string($content);

        $stream = new Stream('php://memory', 'rw');

        $request = new Request(null, [], [], null, null, $stream);

        $request->getBody()->write($content);
        $request->getBody()->rewind();

        return $request;
    }
}
