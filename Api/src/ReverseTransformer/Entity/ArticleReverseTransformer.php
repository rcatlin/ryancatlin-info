<?php

namespace RCatlin\Api\ReverseTransformer\Entity;

use Doctrine\ORM\EntityManager;
use RCatlin\Api\Entity;
use RCatlin\Api\Repository;
use RCatlin\Api\ReverseTransformer;

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
     * @param EntityManager                $entityManager
     * @param Repository\ArticleRepository $articleRepository
     * @param TagReverseTransformer        $tagReverseTransformer
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
     * @param bool  $overrideEmbedded
     *
     * @return null|Entity\Article
     */
    public function reverseTransform(array $values, $overrideEmbedded = true)
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

            if (isset($values['tags'])) {
                $tags = $this->tagReverseTransformer->reverseTransformAll($values['tags']);

                foreach ($tags as $tag) {
                    if ($tag->getId() !== null) {
                        $this->entityManager->flush($tag);
                    } else {
                        $this->entityManager->persist($tag);
                    }
                }

                // Override or Add Embedded Tags
                if ($overrideEmbedded) {
                    $article->setTags($tags);
                } else {
                    $article->addTags($tags);
                }
            }

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
     * @param bool  $overrideEmbedded
     *
     * @return Entity\Article[]
     */
    public function reverseTransformAll(array $multipleValues, $overrideEmbedded = true)
    {
        $articles = [];

        foreach ($multipleValues as $values) {
            $articles[] = $this->reverseTransform($values, $overrideEmbedded);
        }

        return $articles;
    }
}
