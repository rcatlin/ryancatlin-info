<?php

namespace RCatlin\Api\Controller\Api;

use RCatlin\Api\Authentication;
use RCatlin\Api\Behavior\ReadsRequestContent;
use RCatlin\Api\Behavior\RenderError;
use RCatlin\Api\Behavior\RenderResponse;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

class LoginController
{
    use ReadsRequestContent;
    use RenderError;
    use RenderResponse;

    const INVALID_REQUEST_BODY = 'Invalid Request Body: Bad JSON.';
    const MISSING_FIELDS = 'Invalid Request Body: Missing fields.';
    const INVALID_CREDENTIALS = 'Invalid Credentials.';

    /**
     * @var Authentication\Login
     */
    private $authLogin;

    public function __construct(Authentication\Login $authLogin)
    {
        $this->authLogin = $authLogin;
    }

    public function login(Request $request, ApiResponse $response, array $vars = [])
    {
        $content = $this->readRequestJson($request);

        if ($content === false || !is_array($content)) {
            return $this->renderBadRequest($response, self::INVALID_REQUEST_BODY);
        }

        if (!array_key_exists('username', $content) || !array_key_exists('password', $content)) {
            return $this->renderBadRequest($response, self::MISSING_FIELDS);
        }

        $token = $this->authLogin->loginUserFromCredentials($content['username'], $content['password']);

        if ($token === null) {
            return $this->renderBadRequest($response, self::INVALID_CREDENTIALS);
        }

        return $this->renderResult($response, [
            'token' => $token,
        ], StatusCode::ACCEPTED);
    }
}
