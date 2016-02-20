<?php

namespace RCatlin\Api\Controller\Api;

use RCatlin\Api\Entity;
use RCatlin\Api\Repository;
use RCatlin\Api\Serializer;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

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
