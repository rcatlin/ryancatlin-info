<?php

namespace RCatlin\Blog\Controller\Api;

use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Serializer;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class ArticleGetController extends AbstractArticleController
{
    /**
     * @var Repository\ArticleRepository
     */
    private $articleRepository;

    /**
     * @param Repository\ArticleRepository $articleRepository
     * @param Serializer\ScopeBuilder      $scopeBuilder
     */
    public function __construct(
        Repository\ArticleRepository $articleRepository,
        Serializer\ScopeBuilder $scopeBuilder
    ) {
        parent::__construct($scopeBuilder);
        $this->articleRepository = $articleRepository;
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
}