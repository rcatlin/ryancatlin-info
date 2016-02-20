<?php

namespace RCatlin\Api\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Api\Behavior\RenderError;
use RCatlin\Api\Behavior\RenderResponse;
use RCatlin\Api\Repository;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;
use Teapot\StatusCode;

class TagDeleteController
{
    use RenderError;
    use RenderResponse;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Repository\TagRepository
     */
    private $repository;

    /**
     * @param EntityManager            $entityManager
     * @param Repository\TagRepository $repository
     */
    public function __construct(EntityManager $entityManager, Repository\TagRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $vars
     *
     * @return Response
     */
    public function delete(Request $request, Response $response, $vars = [])
    {
        $id = $vars['id'];

        $tag = $this->repository->find($id);

        if ($tag === null) {
            return $this->renderNotFound($response, sprintf(
                'Tag with ID %s not found', $id
            ));
        }

        try {
            $this->entityManager->remove($tag);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        return $this->renderResult($response, [], StatusCode::NO_CONTENT);
    }
}
