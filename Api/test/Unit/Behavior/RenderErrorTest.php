<?php

namespace RCatlin\Api\Test\Unit\Behavior;

use RCatlin\Api\Behavior\RenderError;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\ReadsResponseContent;
use Refinery29\Piston\ApiResponse;

class RenderErrorTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;
    use RenderError;
    use ReadsResponseContent;

    public function testRenderNotFound()
    {
        $message = $this->getFaker()->sentence();

        $response = $this->renderNotFound(new ApiResponse(), $message);

        $this->assertInstanceOf(ApiResponse::class, $response);
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
            $this->readControllerResponse($response)
        );
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderNotFoundRequiresStringMessage()
    {
        $this->renderNotFound(new ApiResponse(), $this->getFaker()->randomNumber());
    }

    public function testRenderBadRequest()
    {
        $message = $this->getFaker()->sentence();

        $response = $this->renderBadRequest(new ApiResponse(), $message);

        $this->assertInstanceOf(ApiResponse::class, $response);
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
            $this->readControllerResponse($response)
        );
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderBadRequestRequiresStringMessage()
    {
        $this->renderBadRequest(new ApiResponse(), $this->getFaker()->randomNumber());
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

        $response = $this->renderValidationErrors(new ApiResponse(), [
            $value0 => [
                $code0 => $title0,
            ],
            $value1 => [
                $code1 => $title1,
            ],
        ]);

        $this->assertInstanceOf(ApiResponse::class, $response);
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
            $this->readControllerResponse($response)
        );
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderValidationErrorsRequiresIntegerCode()
    {
        $faker = $this->getFaker();

        $badValue = $faker->randomNumber();

        $this->renderValidationErrors(new ApiResponse(), [
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

        $this->renderValidationErrors(new ApiResponse(), [
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

        $this->renderValidationErrors(new ApiResponse(), [
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

        $this->renderValidationErrors(new ApiResponse(), [
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

        $response = $this->renderServerError(new ApiResponse(), $message);

        $this->assertInstanceOf(ApiResponse::class, $response);
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
            $this->readControllerResponse($response)
        );
    }

    /**
     * @expectedException \Assert\AssertionFailedException
     */
    public function testRenderServerErrorRequiresStringMessage()
    {
        $this->renderServerError(new ApiResponse(), $this->getFaker()->randomNumber());
    }
}
