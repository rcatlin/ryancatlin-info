<?php

namespace RCatlin\Api\Middleware\Route;

use League\Pipeline\StageInterface;
use RCatlin\Api\Controller;
use Refinery29\Piston\Middleware\Payload;
use Refinery29\Piston\Piston;

class Main implements StageInterface
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

        $subject->get('/', Controller\MainController::class . '::index');

        return $payload;
    }
}
