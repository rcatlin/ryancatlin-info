<?php

namespace RCatlin\Api\Controller\Api;

use RCatlin\Api\Repository\ArticleRepository;
use RCatlin\Api\Serializer\ScopeBuilder;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;

class ArticleCountController extends AbstractArticleController
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        ScopeBuilder $scopeBuilder
    ) {
        parent::__construct($scopeBuilder);
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param Request     $request
     * @param ApiResponse $response
     * @param array       $vars
     *
     * @return ApiResponse
     */
    public function getCount(Request $request, ApiResponse $response, array $vars = [])
    {
        $active = true;

        $params = $request->getQueryParams();
        if (array_key_exists('active', $params)) {
            $active = boolval($params['active']);
        }

        if ($active === false) {
            return $this->renderBadRequest(
                $response,
                'Not Implemented: Retrieving total count of non-active articles.'
            );
        }

        return $this->renderResult($response, [
            'count' => $this->articleRepository->getActiveTotalCount(),
        ]);
    }
}
