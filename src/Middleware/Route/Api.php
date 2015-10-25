<?php

namespace RCatlin\Blog\Middleware\Route;

use League\Pipeline\StageInterface;
use RCatlin\Blog\Controller;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Piston;
use Refinery29\Piston\Router\RouteGroup;

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
            $group->get('status', Controller\Api\StatusController::class . '::get');

            $group->get('articles/{id:number}', Controller\Api\ArticleGetController::class . '::get');
            $group->post('articles', Controller\Api\ArticleCreateController::class . '::create');
            $group->delete('articles/{id:number}', Controller\Api\ArticleDeleteController::class . '::delete');

            $group->get('tags/{id:number}', Controller\Api\TagGetController::class . '::get');
            $group->post('tags', Controller\Api\TagCreateController::class . '::create');
            $group->delete('tags/{id:number}', Controller\Api\TagDeleteController::class . '::delete');
        });

        return $payload;
    }
}
