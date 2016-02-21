<?php

namespace RCatlin\Api\Controller\Api;

use RCatlin\Api\Entity;
use RCatlin\Api\Repository;
use RCatlin\Api\Request\Pagination;
use RCatlin\Api\Serializer;
use RCatlin\Api\Sort;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Middleware\Request\Sorts;
use Refinery29\Piston\Request;

class ArticleGetController extends AbstractArticleController
{
    /**
     * @var Repository\ArticleRepository
     */
    private $articleRepository;

    /**
     * @var Repository\TagRepository
     */
    private $tagRepository;

    /**
     * @param Repository\ArticleRepository $articleRepository
     * @param Serializer\ScopeBuilder      $scopeBuilder
     * @param Repository\TagRepository     $tagRepository
     */
    public function __construct(
        Repository\ArticleRepository $articleRepository,
        Serializer\ScopeBuilder $scopeBuilder,
        Repository\TagRepository $tagRepository
    ) {
        parent::__construct($scopeBuilder);
        $this->articleRepository = $articleRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param Request  $request
     * @param ApiResponse $response
     * @param array    $vars
     *
     * @return ApiResponse
     */
    public function get(Request $request, ApiResponse $response, array $vars = [])
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
     * @param ApiResponse $response
     * @param array    $vars
     *
     * @return ApiResponse
     */
    public function getMostRecent(Request $request, ApiResponse $response, array $vars = [])
    {
        try {
            /* @var Entity\Article|null $article */
            $articles = $this->articleRepository->findAllActiveArticles(0, 1, 'DESC');
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        if ($articles === null || count($articles) <= 0) {
            return $this->renderNotFound($response, 'Most Recent Article Not Found.');
        }

        $scope = $this->getArticleScope($articles[0]);

        return $this->renderResult($response, $scope->toArray());
    }

    /**
     * @param Request $request
     * @param ApiResponse $response
     * @param array $vars
     *
     * @return ApiResponse
     */
    public function getList(Request $request, ApiResponse $response, array $vars = [])
    {
        $limit = 10;
        $offset = 0;

        if ($request->isPaginated()) {
            $offsetLimit = $request->getOffsetLimit();

            $limit = $offsetLimit['limit'];
            $offset = $offsetLimit['offset'];
        }

        if ($request->getSort('created_at') == Sorts::SORT_ASCENDING) {
            $order = Sort::DOCTRINE_ASCENDING;
        } else {
            $order = Sort::DOCTRINE_DESCENDING;
        }

        try {
            /* @var Entity\Article|null $article */
            $articles = $this->articleRepository->findAllActiveArticles($offset, $limit, $order);
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        $scope = $this->getArticlesScope($articles);

        return $this->renderResult($response, $scope->toArray());
    }

    /**
     * @param Request  $request
     * @param ApiResponse $response
     * @param array    $vars
     *
     * @return ApiResponse
     */
    public function getByTag(Request $request, ApiResponse $response, array $vars = [])
    {
        $name = $vars['name'];

        // Find Tag
        try {
            $tag = $this->tagRepository->findOneByName($name);
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        // Verify Tag Found
        if ($tag === null) {
            return $this->renderNotFound($response, sprintf('Tag with name "%s" does not exist.', $name));
        }

        // Get Request Query Parameters
        $query = $request->getQueryParams();

        // Check Offset
        $offset = array_key_exists('offset', $query) && $query['offset'] !== null ? $query['offset'] : 0;
        if (!is_int($offset)) {
            return $this->renderBadRequest($response, '"offset" parameter must be an integer.');
        }

        // Check Limit
        $limit = array_key_exists('limit', $query) && $query['limit'] !== null ? $query['limit'] : 5;
        if (!is_int($offset)) {
            return $this->renderBadRequest($response, '"limit" parameter must be an integer.');
        }

        // Check Order
        $order = Pagination::ORDER_DESCENDING;
        if (array_key_exists('order', $query) && $query['order'] !== null) {
            $order = strtoupper($query['order']);
        }
        if (!Pagination::inOrders($order)) {
            return $this->renderBadRequest($response, sprintf(
                '"order" must be: %s', implode(', ', Pagination::$orders)
            ));
        }

        // Find Articles
        try {
            $articles = $this->articleRepository->findActiveByTag($tag, $offset, $limit, $order);
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        // Serialize and Return Result
        $scope = $this->getArticlesScope($articles);

        return $this->renderResult($response, $scope->toArray());
    }
}
