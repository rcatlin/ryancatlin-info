<?php

namespace RCatlin\Api\Middleware\Route;

use League\Pipeline\StageInterface;
use RCatlin\Api\Controller;
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

            // Articles
            $group->delete('articles/{id:number}', Controller\Api\ArticleDeleteController::class . '::delete');
            $group->get('articles', Controller\Api\ArticleGetController::class . '::getList');
            $group->get('articles/{id:number}', Controller\Api\ArticleGetController::class . '::get');
            $group->get('articles/mostrecent', Controller\Api\ArticleGetController::class . '::getMostRecent');
            $group->get('articles/tag/{name:word}', Controller\Api\ArticleGetController::class . '::getByTag');
            $group->patch('articles/{id:number}', Controller\Api\ArticleUpdateController::class . '::partialUpdate');
            $group->post('articles', Controller\Api\ArticleCreateController::class . '::create');
            $group->put('articles/{id:number}', Controller\Api\ArticleUpdateController::class . '::update');
            $group->get('articles/count', Controller\Api\ArticleCountController::class . '::getCount');

            // Tags
            $group->delete('tags/{id:number}', Controller\Api\TagDeleteController::class . '::delete');
            $group->get('tags/{id:number}', Controller\Api\TagGetController::class . '::get');
            $group->post('tags', Controller\Api\TagCreateController::class . '::create');
            $group->put('tags/{id:number}', Controller\Api\TagUpdateController::class . '::update');

            // User
            $group->post('users/login', Controller\Api\LoginController::class . '::login');
        });

        return $payload;
    }
}
