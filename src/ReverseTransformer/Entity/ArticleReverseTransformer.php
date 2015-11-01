<?php

namespace RCatlin\Blog\ReverseTransformer\Entity;

use Doctrine\ORM\EntityManager;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\ReverseTransformer;

class ArticleReverseTransformer implements ReverseTransformer\ReverseTransformerInterface
{
    /**
     * @var Repository\ArticleRepository
     */
    private $articleRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TagReverseTransformer
     */
    private $tagReverseTransformer;

    /**
     * @param TagReverseTransformer $tagReverseTransformer
     */
    public function __construct(
        EntityManager $entityManager,
        Repository\ArticleRepository $articleRepository,
        ReverseTransformer\Entity\TagReverseTransformer $tagReverseTransformer
    ) {
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->tagReverseTransformer = $tagReverseTransformer;
    }

    /**
     * @param array $values
     *
     * @return null|Entity\Article
     */
    public function reverseTransform(array $values)
    {
        if (array_key_exists('id', $values)) {
            /** @var Entity\Article $article */
            $article = $this->articleRepository->find($values['id']);

            if ($article === null) {
                // TODO - Throw Exception
                return;
            }

            if (isset($values['slug'])) {
                $article->setSlug($values['slug']);
            }

            if (isset($values['title'])) {
                $article->setTitle($values['title']);
            }

            if (isset($values['content'])) {
                $article->setContent($values['content']);
            }

            $tags = [];
            if (isset($values['tags'])) {
                $tags = $this->tagReverseTransformer->reverseTransformAll($values['tags']);
                foreach ($tags as $tag) {
                    if ($tag->getId() !== null) {
                        $this->entityManager->flush($tag);
                    } else {
                        $this->entityManager->persist($tag);
                    }
                }
            }
            $article->setTags($tags);

            if (isset($values['active'])) {
                $article->setActive($values['active']);
            }

            return $article;
        }

        $tags = [];
        if (isset($values['tags'])) {
            $tags = $this->tagReverseTransformer->reverseTransformAll($values['tags']);
        }
        $values['tags'] = $tags;

        return Entity\Article::fromArray($values);
    }

    /**
     * @param array $multipleValues
     *
     * @return Entity\Article[]
     */
    public function reverseTransformAll(array $multipleValues)
    {
        $articles = [];

        foreach ($multipleValues as $values) {
            $articles[] = $this->reverseTransform($values);
        }

        return $articles;
    }
}
