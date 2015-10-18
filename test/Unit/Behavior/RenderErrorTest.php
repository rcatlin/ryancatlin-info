<?php

namespace RCatlin\Blog\Test\Unit\Behavior;

use RCatlin\Blog\Behavior\RenderError;
use RCatlin\Blog\Test\Unit\HasFaker;
use RCatlin\Blog\Test\Unit\ReadsResponseContent;
use Refinery29\Piston\Response;

class RenderErrorTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;
    use RenderError;
    use ReadsResponseContent;

    public function testRenderNotFound()
    {
        $message = $this->getFaker()->sentence();

        $response = $this->renderNotFound(new Response(), $message);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame(
            json_encode([
                'errors' => [
                    [
                        'title' => $message,
                        'code' => 0,
                    ],
                ],
            ]),
            $this->readResponseContent($response)
        );
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderNotFoundRequiresStringMessage()
    {
        $this->renderNotFound(new Response(), $this->getFaker()->randomNumber());
    }

    public function testRenderBadRequest()
    {
        $message = $this->getFaker()->sentence();

        $response = $this->renderBadRequest(new Response(), $message);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame(
            json_encode([
                'errors' => [
                    [
                        'title' => $message,
                        'code' => 0,
                    ],
                ],
            ]),
            $this->readResponseContent($response)
        );
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderBadRequestRequiresStringMessage()
    {
        $this->renderBadRequest(new Response, $this->getFaker()->randomNumber());
    }

    public function testRenderValidationErrors()
    {
        $faker = $this->getFaker();

        $firstCode = $faker->randomNumber();
        $firstMessage = $faker->sentence();

        $secondCode = $faker->randomNumber();
        $secondMessage = $faker->sentence();

        $response = $this->renderValidationErrors(new Response(), [
            $firstCode => $firstMessage,
            $secondCode => $secondMessage,
        ]);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame(
            json_encode([
                'errors' => [
                    [
                        'title' => $firstMessage,
                        'code' => 0,
                    ],
                    [
                        'title' => $secondMessage,
                        'code' => 0,
                    ],
                ],
            ]),
            $this->readResponseContent($response)
        );
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderValidationErrorsRequiresIntegerCode()
    {
        $faker = $this->getFaker();

        $badCode = $faker->word;

        $this->renderValidationErrors(new Response(), [
           [
                $badCode => $faker->sentence,
           ],
        ]);
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderValidationErrorsRequiresStringTitle()
    {
        $faker = $this->getFaker();

        $badTitle = $faker->randomNumber();

        $this->renderValidationErrors(new Response(), [
            [
                $faker->randomNumber() => $badTitle,
            ],
        ]);
    }

    public function testRenderServerError()
    {
        $message = $this->getFaker()->sentence();

        $response = $this->renderServerError(new Response(), $message);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(500, $response->getStatusCode());
        $this->assertSame(
            json_encode([
                'errors' => [
                    [
                        'title' => $message,
                        'code' => 0,
                    ],
                ],
            ]),
            $this->readResponseContent($response)
        );
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderServerErrorRequiresStringMessage()
    {
        $this->renderServerError(new Response(), $this->getFaker()->randomNumber());
    }
}
