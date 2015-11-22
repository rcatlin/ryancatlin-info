<?php

namespace RCatlin\Blog\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Blog\Behavior\ReadsRequestContent;
use RCatlin\Blog\Behavior\RenderError;
use RCatlin\Blog\Repository;
use RCatlin\Blog\ReverseTransformer;
use RCatlin\Blog\Serializer;
use RCatlin\Blog\Validator;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;

class ArticleUpdateController extends AbstractArticleController
{
    use ReadsRequestContent;
    use RenderError;

    /**
     * @var Repository\ArticleRepository
     */
    private $articleRepository;

    /**
     * @var ReverseTransformer\Entity\ArticleReverseTransformer
     */
    private $articleReverseTransformer;

    /**
     * @var Validator\Entity\ArticleValidator
     */
    private $articleValidator;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param Repository\ArticleRepository                        $articleRepository
     * @param ReverseTransformer\Entity\ArticleReverseTransformer $articleReverseTransformer
     * @param Validator\Entity\ArticleValidator                   $articleValidator
     * @param EntityManager                                       $entityManager
     * @param Serializer\ScopeBuilder                             $scopeBuilder
     */
    public function __construct(
        Repository\ArticleRepository $articleRepository,
        ReverseTransformer\Entity\ArticleReverseTransformer $articleReverseTransformer,
        Validator\Entity\ArticleValidator $articleValidator,
        EntityManager $entityManager,
        Serializer\ScopeBuilder $scopeBuilder
    ) {
        parent::__construct($scopeBuilder);

        $this->articleRepository = $articleRepository;
        $this->articleReverseTransformer = $articleReverseTransformer;
        $this->articleValidator = $articleValidator;
        $this->entityManager = $entityManager;
    }

    public function update(Request $request, Response $response, $vars = [])
    {
        $id = $vars['id'];

        $article = $this->articleRepository->find($id);

        if ($article === null) {
            return $this->renderNotFound($response, sprintf(
                'Article with id %s not found.', $id
            ));
        }

        $values = $this->readRequestJson($request);

        // Validate
        $validationResult = $this->articleValidator->validate($values, Validator\Context::UPDATE);
        if ($validationResult->isNotValid()) {
            return $this->renderValidationErrors($response, $validationResult->getMessages());
        }

        $values['id'] = $id;

        // Reverse Transform and Update
        try {
            $article = $this->articleReverseTransformer->reverseTransform($values, false);
        } catch (\Exception $e) {
            return $this->renderServerError($response, 'An error occurred processing the data.');
        }

        // Flush
        try {
            $this->entityManager->flush($article);
        } catch (\Exception $e) {
            return $this->renderServerError($response, 'An error occurred saving the data.' . $e->getMessage());
        }

        // Serialize
        $scope = $this->getArticleScope($article);

        return $this->renderResult($response, $scope->toArray(), 202);
    }

    public function partialUpdate(Request $request, Response $response, $vars = [])
    {
        $id = $vars['id'];

        $article = $this->articleRepository->find($id);

        if ($article == null) {
            return $this->renderNotFound($response, sprintf(
                'Article with id %s not found.', $id
            ));
        }

        $values = $this->readRequestJson($request);

        $values['id'] = $id;

        // Validate
        $validationResult = $this->articleValidator->validate($values, Validator\Context::PARTIAL_UPDATE);
        if ($validationResult->isNotValid()) {
            return $this->renderValidationErrors($response, $validationResult->getMessages());
        }

        // Reverse Transform and Update
        try {
            $article = $this->articleReverseTransformer->reverseTransform($values, false);
        } catch (\Exception $e) {
            return $this->renderServerError($response, 'An error occurred processing the data.');
        }

        // Persist
        try {
            $this->entityManager->flush($article);
        } catch (\Exception $e) {
            return $this->renderServerError($response, 'An error occurred saving the data.' . $e->getMessage());
        }

        // Serialize
        $scope = $this->getArticleScope($article);

        return $this->renderResult($response, $scope->toArray(), 202);
    }
}
