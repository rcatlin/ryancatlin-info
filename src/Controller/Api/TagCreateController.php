<?php

namespace RCatlin\Blog\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Blog\ReverseTransformer;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Validator;
use RCatlin\Blog\Validator\Context;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class TagCreateController extends AbstractTagController
{
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
     * @param EntityManager                                   $entityManager
     * @param ReverseTransformer\Entity\TagReverseTransformer $tagReverseTransformer
     * @param Serializer\ScopeBuilder                         $scopeBuilder
     * @param Validator\Entity\TagValidator                   $tagValidator
     */
    public function __construct(
        EntityManager $entityManager,
        ReverseTransformer\Entity\TagReverseTransformer $tagReverseTransformer,
        Serializer\ScopeBuilder $scopeBuilder,
        Validator\Entity\TagValidator $tagValidator
    ) {
        parent::__construct($scopeBuilder);

        $this->entityManager = $entityManager;
        $this->tagReverseTransformer = $tagReverseTransformer;
        $this->tagValidator = $tagValidator;
    }

    /**
     * @param Response $response
     * @param Request  $request
     *
     * @return Response
     */
    public function create(Request $request, Response $response, array $vars = [])
    {
        $content = $request->getBody()->getContents();

        try {
            $decodedContent = json_decode($content, true);
        } catch (\Exception $e) {
            $decodedContent = null;
        }

        if ($decodedContent === null) {
            return $this->renderBadRequest($response, 'Invalid JSON.');
        }

        $validationResult = $this->tagValidator->validate($decodedContent, Context::CREATE);

        if ($validationResult->isNotValid()) {
            return $this->renderValidationErrors($response, $validationResult->getMessages());
        }

        $tag = $this->tagReverseTransformer->reverseTransform($decodedContent);

        try {
            $this->entityManager->persist($tag);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        return $this->renderResult(
            $response,
            $this->getTagScope($tag)->toArray()
        );
    }
}
