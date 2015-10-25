<?php

namespace RCatlin\Blog\Test\Unit\Behavior;

use RCatlin\Blog\Behavior\RenderError;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\ReadsResponseContent;
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
        $this->renderBadRequest(new Response(), $this->getFaker()->randomNumber());
    }

    public function testRenderValidationErrors()
    {
        $faker = $this->getFaker();

        $value0 = $faker->word;
        $code0 = $faker->word;
        $title0 = $faker->sentence();

        $value1 = $faker->word;
        $code1 = $faker->word;
        $title1 = $faker->sentence();

        $response = $this->renderValidationErrors(new Response(), [
            $value0 => [
                $code0 => $title0,
            ],
            $value1 => [
                $code1 => $title1,
            ],
        ]);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame(
            json_encode([
                'errors' => [
                    [
                        'title' => $title0,
                        'code' => 0,
                    ],
                    [
                        'title' => $title1,
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

        $badValue = $faker->randomNumber();

        $this->renderValidationErrors(new Response(), [
           [
                $badValue => [
                    $faker->word => $faker->sentence,
                ],
           ],
        ]);
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderValidationErrorsRequiresArrayAsValue()
    {
        $faker = $this->getFaker();

        $notAnArray = $faker->word;

        $this->renderValidationErrors(new Response(), [
            [
                $faker->word => $notAnArray,
            ],
        ]);
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderValidationErrorsRequiresStringCode()
    {
        $faker = $this->getFaker();

        $badCode = $faker->randomNumber();

        $this->renderValidationErrors(new Response(), [
            [
                $faker->word => [
                    $badCode => $faker->sentence,
                ],
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
                $faker->word => [
                    $faker->word => $badTitle,
                ],
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
