<?php

namespace RCatlin\Blog\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Blog\Behavior\RenderError;
use RCatlin\Blog\Behavior\RenderResponse;
use RCatlin\Blog\Repository;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class ArticleDeleteController
{
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
     * @param EntityManager                $entityManager
     * @param Repository\ArticleRepository $articleRepository
     */
    public function __construct(EntityManager $entityManager, Repository\ArticleRepository $articleRepository)
    {
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
    }

    public function delete(Request $request, Response $response, $vars = [])
    {
        $id = $vars['id'];

        $article = $this->articleRepository->find($id);

        if ($article == null) {
            return $this->renderNotFound($response, sprintf(
                'Article with id %s not found.', $id
            ));
        }

        try {
            $this->entityManager->remove($article);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return $this->renderServerError($response, $e->getMessage());
        }

        return $this->renderResult($response, [], 204);
    }
}
