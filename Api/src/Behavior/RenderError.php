<?php

namespace RCatlin\Blog\Behavior;

use Assert\Assertion;
use Refinery29\ApiOutput\Resource\Error\ErrorCollection;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\Response;
use Teapot\StatusCode;

trait RenderError
{
    /**
     * @param Response $response
     * @param $message
     *
     * @return Response
     */
    public function renderNotFound(Response $response, $message)
    {
        Assertion::string($message);

        return $this->renderErrors($response, StatusCode::NOT_FOUND, ResourceFactory::errorCollection([
            ResourceFactory::error($message, 0),
        ]));
    }

    /**
     * @param Response $response
     * @param $message
     *
     * @return Response
     */
    public function renderBadRequest(Response $response, $message)
    {
        Assertion::string($message);

        return $this->renderErrors($response, StatusCode::BAD_REQUEST, ResourceFactory::errorCollection([
            ResourceFactory::error($message, 0),
        ]));
    }

    /**
     * @param Response $response
     * @param array    $validationErrors
     *
     * @return Response
     */
    public function renderValidationErrors(Response $response, array $validationErrors)
    {
        $errors = [];
        foreach ($validationErrors as $value => $valueErrors) {
            Assertion::string($value);
            Assertion::isArray($valueErrors);
            foreach ($valueErrors as $code => $title) {
                Assertion::string($code);
                Assertion::string($title);
                $errors[] = ResourceFactory::error($title, 0);
            }
        }

        return $this->renderErrors($response, StatusCode::BAD_REQUEST, ResourceFactory::errorCollection($errors));
    }

    /**
     * @param Response $response
     * @param $message
     *
     * @return Response
     */
    public function renderServerError(Response $response, $message)
    {
        Assertion::string($message);

        return $this->renderErrors($response, StatusCode::INTERNAL_SERVER_ERROR, ResourceFactory::errorCollection([
            ResourceFactory::error($message, 0),
        ]));
    }

    /**
     * @param Response $response
     * @param $statusCode
     * @param ErrorCollection $errors
     *
     * @return Response
     */
    private function renderErrors(Response $response, $statusCode, ErrorCollection $errors)
    {
        Assertion::integer($statusCode);

        /** @var Response $response */
        $response = $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode)
        ;

        $response->setErrors($errors);

        return $response;
    }
}
