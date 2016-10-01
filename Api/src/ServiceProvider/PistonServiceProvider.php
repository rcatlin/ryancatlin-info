<?php

namespace RCatlin\Api\ServiceProvider;

use Assert\Assertion;
use Exception;
use Firebase\JWT\ExpiredException;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Api\Exception\NotAuthorized;
use RCatlin\Api\Middleware;
use Refinery29\Piston\Piston;
use Teapot\StatusCode;

class PistonServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Piston::class,
    ];

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
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Piston::class, function () use ($container) {
            $app = new Piston($container);

            $app->addMiddleware(new Middleware\Route\Api());
            $app->addMiddleware(new Middleware\Route\AuthenticatedApi($this->authHeader, $this->key));

            $app->registerException(ExpiredException::class, function (Piston $app, Exception $exception) {
                $app->getErrorResponse(StatusCode::UNAUTHORIZED, json_encode([
                    'message' => 'Authentication has expired.',
                ]));
            });

            $app->registerException(NotAuthorized::class, function (Piston $app, Exception $exception) {
                $app->getErrorResponse(StatusCode::UNAUTHORIZED, json_encode([
                    'message' => $exception->getMessage(),
                ]));
            });

            return $app;
        });
    }
}
