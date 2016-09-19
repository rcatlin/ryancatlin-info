<?php

namespace RCatlin\Api\Middleware;

use Assert\Assertion;
use Assert\InvalidArgumentException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use League\Pipeline\StageInterface;
use RCatlin\Api\Exception\NotAuthorized;
use Refinery29\Piston\Middleware\Payload;

class Authenticated implements StageInterface
{
    private $authHeader;

    private $key;

    public function __construct($authHeader, $key)
    {
        Assertion::string($authHeader);
        Assertion::string($key);

        $this->authHeader = $authHeader;
        $this->key = $key;
    }

    public function process($payload)
    {
        /* @var Payload $payload */
        $values = $payload
            ->getRequest()
            ->getHeader($this->authHeader);

        $token = array_pop($values);

        try {
            Assertion::string($token);
        } catch (InvalidArgumentException $exception) {
            throw new NotAuthorized();
        }

        try {
            JWT::decode($token, $this->key, ['HS256']);
        } catch (\Exception $exception) {
            if ($exception instanceof ExpiredException) {
                throw $exception;
            }

            throw new NotAuthorized();
        }

        return $payload;
    }
}
