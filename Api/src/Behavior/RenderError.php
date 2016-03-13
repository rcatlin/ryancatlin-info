<?php

namespace RCatlin\Api\Behavior;

use Assert\Assertion;
use Refinery29\ApiOutput\Resource\Error\ErrorCollection;
use Refinery29\ApiOutput\Resource\ResourceFactory;
use Refinery29\Piston\ApiResponse;
use Teapot\StatusCode;

trait RenderError
{
    /**
     * @param ApiResponse $response
     * @param $message
     *
     * @return ApiResponse
     */
    public function renderNotFound(ApiResponse $response, $message)
    {
        Assertion::string($message);

        return $this->renderErrors($response, StatusCode::NOT_FOUND, ResourceFactory::errorCollection([
            ResourceFactory::error($message, 0),
        ]));
    }

    /**
     * @param ApiResponse $response
     * @param $message
     *
     * @return ApiResponse
     */
    public function renderBadRequest(ApiResponse $response, $message)
    {
        Assertion::string($message);

        return $this->renderErrors($response, StatusCode::BAD_REQUEST, ResourceFactory::errorCollection([
            ResourceFactory::error($message, 0),
        ]));
    }

    /**
     * @param ApiResponse $response
     * @param array       $validationErrors
     *
     * @return ApiResponse
     */
    public function renderValidationErrors(ApiResponse $response, array $validationErrors)
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
     * @param ApiResponse $response
     * @param $message
     *
     * @return ApiResponse
     */
    public function renderServerError(ApiResponse $response, $message)
    {
        Assertion::string($message);

        return $this->renderErrors($response, StatusCode::INTERNAL_SERVER_ERROR, ResourceFactory::errorCollection([
            ResourceFactory::error($message, 0),
        ]));
    }

    /**
     * @param ApiResponse $response
     * @param $statusCode
     * @param ErrorCollection $errors
     *
     * @return ApiResponse
     */
    private function renderErrors(ApiResponse $response, $statusCode, ErrorCollection $errors)
    {
        Assertion::integer($statusCode);

        /** @var ApiResponse $response */
        $response = $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode)
        ;

        $response->setErrors($errors);

        return $response;
    }
}
