<?php

namespace RCatlin\Api\Middleware\Route;

use Assert\Assertion;
use League\Pipeline\StageInterface;
use RCatlin\Api\Controller;
use RCatlin\Api\Middleware\Authenticated;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Router\RouteGroup;

class AuthenticatedApi implements StageInterface
{
    /**
     * @var string
     */
    private $authHeader;

    /**
     * @var string
     */
    private $key;

    /**
     * @param string $authHeader
     * @param string $key
     */
    public function __construct($authHeader, $key)
    {
        Assertion::string($authHeader);
        Assertion::string($key);

        $this->authHeader = $authHeader;
        $this->key = $key;
    }

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload)
    {
        /** @var Piston $subject */
        $subject = $payload->getSubject();

        $authenticated = new Authenticated($this->authHeader, $this->key);

        $subject->group('api', function (RouteGroup $group) {
            $group->get('users/login/check', Controller\Api\LoggedInController::class . '::check');
        })->addMiddleware($authenticated);

        return $payload;
    }
}
