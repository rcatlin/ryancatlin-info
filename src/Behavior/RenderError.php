<?php

namespace RCatlin\Blog\Behavior;

use Assert\Assertion;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Response;

trait RenderError
{
    public function renderNotFound(Response $response, $message)
    {
        Assertion::string($message);

        $response = $response->setStatusCode(404);
        $response->setErrors(
            ResourceFactory::errorCollection([
                ResourceFactory::error($message, 0)
            ])
        );

        return $response;
    }

    public function renderBadRequest(Response $response, $message)
    {
        Assertion::string($message);

        $response = $response->setStatusCode(400);
        $response->setErrors(
            ResourceFactory::errorCollection([
                ResourceFactory::error($message, 0),
            ])
        );

        return $response;
    }

    public function renderValidationError(Response $response, array $errors)
    {
        $response = $response->setStatusCode(400);

        $errors = [];
        foreach ($errors as $error) {
            $errors[] = ResourceFactory::error($error, 0);
        }

        $response->setErrors(ResourceFactory::errorCollection($errors));

        return $response;
    }
}
