<?php

namespace RCatlin\Blog\Controller\Api;

use Doctrine\ORM\EntityManager;
use League\Fractal\Scope;
use RCatlin\Blog\Behavior;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Validator;
use RCatlin\Blog\Validator\Context;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class TagController
{
    use Behavior\RenderError;
    use Behavior\RenderResponse;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Serializer\ScopeBuilder
     */
    private $scopeBuilder;

    /**
     * @var Repository\TagRepository
     */
    private $tagRepository;

    /**
     * @var Validator\Entity\TagValidator
     */
    private $tagValidator;

    /**
     * @param EntityManager                 $entityManager
     * @param Serializer\ScopeBuilder       $scopeBuilder
     * @param Repository\TagRepository      $tagRepository
     * @param Validator\Entity\TagValidator $tagValidator
     */
    public function __construct(
        EntityManager $entityManager,
        Serializer\ScopeBuilder $scopeBuilder,
        Repository\TagRepository $tagRepository,
        Validator\Entity\TagValidator $tagValidator
    ) {
        $this->entityManager = $entityManager;
        $this->scopeBuilder = $scopeBuilder;
        $this->tagRepository = $tagRepository;
        $this->tagValidator = $tagValidator;
    }

    /**
     * @param Response $response
     * @param Request  $request
     * @param array    $vars
     *
     * @return Response
     */
    public function get(Request $request, Response $response, array $vars = [])
    {
        if (!isset($vars['id'])) {
            return $this->renderBadRequest($response, 'Missing required id parameter');
        }

        /** @var int $id */
        $id = intval($vars['id']);

        /** @var Entity\Tag|null $tag */
        $tag = $this->tagRepository->findOneBy(['id' => $id]);

        if (!$tag) {
            return $this->renderNotFound(
                $response,
                sprintf('Tag with id %s not found.', $id)
            );
        }

        return $this->renderResult(
            $response,
            $this->getTagScope($tag)->toArray()
        );
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

        $tag = Entity\Tag::fromArray($decodedContent);

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

    /**
     * @param Entity\Tag $tag
     *
     * @return Scope
     */
    private function getTagScope(Entity\Tag $tag)
    {
        return $this->scopeBuilder->buildItem(Entity\Tag::class, $tag);
    }
}
