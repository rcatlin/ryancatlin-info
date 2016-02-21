<?php

namespace RCatlin\Api\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Api\Behavior\ReadsRequestContent;
use RCatlin\Api\Behavior\RenderError;
use RCatlin\Api\ReverseTransformer;
use RCatlin\Api\Serializer;
use RCatlin\Api\Validator;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

class TagUpdateController extends  AbstractTagController
{
    use ReadsRequestContent;
    use RenderError;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ReverseTransformer\Entity\TagReverseTransformer
     */
    private $tagReverseTransformer;

    /**
     * @var Validator\Entity\TagValidator
     */
    private $tagValidator;

    /**
     * @param EntityManager $entityManager
     * @param Serializer\ScopeBuilder $scopeBuilder
     * @param ReverseTransformer\Entity\TagReverseTransformer $tagReverseTransformer
     * @param Validator\Entity\TagValidator $tagValidator
     */
    public function __construct(
        EntityManager $entityManager,
        Serializer\ScopeBuilder $scopeBuilder,
        ReverseTransformer\Entity\TagReverseTransformer $tagReverseTransformer,
        Validator\Entity\TagValidator $tagValidator
    ) {
        parent::__construct($scopeBuilder);
        $this->entityManager = $entityManager;
        $this->tagReverseTransformer = $tagReverseTransformer;
        $this->tagValidator = $tagValidator;
    }

    /**
     * @param Request $request
     * @param ApiResponse $response
     * @param array $vars
     *
     * @return ApiResponse
     */
    public function update(Request $request, ApiResponse $response, $vars = [])
    {
        $id = $vars['id'];

        $values = $this->readRequestJson($request);

        // Validate
        $validationResult = $this->tagValidator->validate($values, Validator\Context::UPDATE);
        if ($validationResult->isNotValid()) {
            return $this->renderValidationErrors($response, $validationResult->getMessages());
        }

        $values['id'] = $id;

        // Reverse Transform and Update
        try {
            $tag = $this->tagReverseTransformer->reverseTransform($values, false);
        } catch (\Exception $e) {
            return $this->renderServerError($response, 'An error occurred processing the data.');
        }

        if ($tag === null) {
            return $this->renderNotFound($response, sprintf(
                'Tag with id %s not found.', $id
            ));
        }

        // Flush
        try {
            $this->entityManager->flush($tag);
        } catch (\Exception $e) {
            return $this->renderServerError($response, 'An error occurred saving the data.');
        }

        // Serialize
        $scope = $this->getTagScope($tag);

        return $this->renderResult($response, $scope->toArray(), StatusCode::ACCEPTED);
    }
}
