<?php

namespace RCatlin\Blog\Controller\Api;

use RCatlin\Blog\Behavior;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Serializer\Transformer;
use Refinery29\Piston\Http\Request;
use Refinery29\Piston\Http\Response;
use Refinery29\Piston\Router\Routes\Routeable;

class TagController implements Routeable
{
    use Behavior\RenderError;
    use Behavior\RenderResponse;

    /**
     * @var Repository\TagRepository
     */
    private $tagRepository;

    /**
     * @var Transformer\Entity\TagTransformer
     */
    private $tagTransformer;

    /**
     * @param Repository\TagRepository $tagRepository
     */
    public function __construct(
        Repository\TagRepository $tagRepository,
        Transformer\Entity\TagTransformer $tagTransformer
    ) {
        $this->tagRepository = $tagRepository;
        $this->tagTransformer = $tagTransformer;
    }

    /**
     * @param Response $response
     * @param Request  $request
     * @param array    $vars
     *
     * @return Response
     */
    public function get(Response $response, Request $request, array $vars = [])
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
            $this->tagTransformer->transform($tag)
        );
    }
}
