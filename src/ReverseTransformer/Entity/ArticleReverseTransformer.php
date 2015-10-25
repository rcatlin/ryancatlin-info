<?php

namespace RCatlin\Blog\ReverseTransformer\Entity;

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
     * @var TagReverseTransformer
     */
    private $tagReverseTransformer;

    /**
     * @param TagReverseTransformer $tagReverseTransformer
     */
    public function __construct(
        Repository\ArticleRepository $articleRepository,
        ReverseTransformer\Entity\TagReverseTransformer $tagReverseTransformer
    ) {
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
        if (isset($values['id'])) {
            /** @var Entity\Article $article */
            $article = $this->articleRepository->find($values['id']);

            if ($article === null) {
                // TOOD - Throw Exception
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
