<?php

namespace RCatlin\Blog\Controller\Api;

use Doctrine\ORM\EntityManager;
use League\Fractal\Scope;
use RCatlin\Blog\Behavior\ReadsRequestContent;
use RCatlin\Blog\Behavior\RenderError;
use RCatlin\Blog\Behavior\RenderResponse;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Validator;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class ArticleController
{
    use ReadsRequestContent;
    use RenderError;
    use RenderResponse;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Repository\ArticleRepository
     */
    private $articleRepository;

    /**
     * @var Serializer\ScopeBuilder
     */
    private $scopeBuilder;

    /**
     * @var Validator\Entity\ArticleValidator
     */
    private $articleValidator;

    /**
     * @param Repository\ArticleRepository      $articleRepository
     * @param Serializer\ScopeBuilder           $scopeBuilder
     * @param Validator\Entity\ArticleValidator $articleValidator
     */
    public function __construct(
        EntityManager $entityManager,
        Repository\ArticleRepository $articleRepository,
        Serializer\ScopeBuilder $scopeBuilder,
        Validator\Entity\ArticleValidator $articleValidator
    ) {
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->scopeBuilder = $scopeBuilder;
        $this->articleValidator = $articleValidator;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $vars
     *
     * @return Response
     */
    public function get(Request $request, Response $response, array $vars = [])
    {
        $id = $vars['id'];

        /** @var Entity\Article|null $article */
        $article = $this->articleRepository->find($id);

        if ($article === null) {
            return $this->renderNotFound(
                $response,
                sprintf('Article with id %s not found', $id)
            );
        }

        $scope = $this->getArticleScope($article);

        return $this->renderResult($response, $scope->toArray());
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

        try {
            $article = Entity\Article::fromArray($json);

            $this->entityManager->persist($article);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        $scope = $this->getArticleScope($article);

        return $this->renderResult($response, $scope->toArray());
    }

    /**
     * @param Entity\Article $article
     *
     * @return Scope
     */
    private function getArticleScope(Entity\Article $article)
    {
        return $this->scopeBuilder->buildItem(Entity\Article::class, $article);
    }
}
