<?php

namespace RCatlin\Blog\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Validator;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class ArticleCreateController extends AbstractArticleController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Validator\Entity\ArticleValidator
     */
    private $articleValidator;

    /**
     * @param EntityManager $entityManager
     * @param Serializer\ScopeBuilder $scopeBuilder
     * @param Validator\Entity\ArticleValidator $articleValidator
     */
    public function __construct(
        EntityManager $entityManager,
        Serializer\ScopeBuilder $scopeBuilder,
        Validator\Entity\ArticleValidator $articleValidator
    ) {
        parent::__construct($scopeBuilder);

        $this->entityManager = $entityManager;
        $this->articleValidator = $articleValidator;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $vars
     *
     * @return Response
     */
    public function create(Request $request, Response $response, array $vars = [])
    {
        $json = $this->readRequestJson($request);

        if ($json === null) {
            return $this->renderBadRequest($response, 'Bad Request JSON');
        }

        $validationResult = $this->articleValidator->validate($json, Validator\Context::CREATE);

        if ($validationResult->isNotValid()) {
            return $this->renderValidationErrors($response, $validationResult->getMessages());
        }

        $values = $json;

        if (!empty($json['tags'])) {
            $values['tags'] = [];
            foreach ($json['tags'] as $tag) {
                $values[] = Entity\Tag::fromArray($tag);
            }
        }

        try {
            $article = Entity\Article::fromArray($values);
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        try {
            $this->entityManager->flush();
            $this->entityManager->persist($article);
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        $scope = $this->getArticleScope($article);

        return $this->renderResult($response, $scope->toArray());
    }
}
