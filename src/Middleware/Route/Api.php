<?php

namespace RCatlin\Blog\Middleware\Route;

use League\Pipeline\StageInterface;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Router\RouteGroup;
use RCatlin\Blog\Controller;

class Api implements StageInterface
{

    /**
     * Process the payload.
     *
     * @param Payload $payload
     *
     * @return Payload
     */
    public function process($payload)
    {
        /** @var Piston $subject */
        $subject = $payload->getSubject();

        $subject->group('api', function (RouteGroup $group) {
            $group->get('tags/{id:number}', Controller\Api\TagController::class . '::get');
        });

        return $payload;
    }
}
