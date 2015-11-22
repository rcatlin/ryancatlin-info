<?php

namespace RCatlin\Blog\Test;

use GuzzleHttp\Psr7\Stream;

trait CreatesGuzzleStream
{
    /**
     * @param $content
     *
     * @return Stream
     */
    public function createStreamFromString($content)
    {
        return \GuzzleHttp\Psr7\stream_for($content);
    }

    /**
     * @param array $content
     *
     * @return Stream
     */
    public function createStreamFromArray(array $content)
    {
        return $this->createStreamFromString(
            json_encode($content)
        );
    }
}
