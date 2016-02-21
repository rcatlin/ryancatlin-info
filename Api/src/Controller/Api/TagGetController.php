<?php

namespace RCatlin\Api\Controller\Api;

use RCatlin\Api\Entity;
use RCatlin\Api\Repository;
use RCatlin\Api\Serializer;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;

class TagGetController extends AbstractTagController
{
    /**
     * @var Repository\TagRepository
     */
    private $tagRepository;

    /**
     * @param Serializer\ScopeBuilder  $scopeBuilder
     * @param Repository\TagRepository $tagRepository
     */
    public function __construct(
        Serializer\ScopeBuilder $scopeBuilder,
        Repository\TagRepository $tagRepository
    ) {
        parent::__construct($scopeBuilder);

        $this->tagRepository = $tagRepository;
    }

    /**
     * @param ApiResponse $response
     * @param Request     $request
     * @param array       $vars
     *
     * @return ApiResponse
     */
    public function get(Request $request, ApiResponse $response, array $vars = [])
    {
        if (!isset($vars['id'])) {
            return $this->renderBadRequest($response, 'Missing required id parameter');
        }

        /** @var int $id */
        $id = intval($vars['id']);

        /** @var Entity\Tag|null $tag */
        $tag = $this->tagRepository->find($id);

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
}
