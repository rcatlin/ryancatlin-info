<?php

namespace RCatlin\Blog\Transformer\Entity;

use Doctrine\Common\Collections\Collection;
use League\Fractal\TransformerAbstract;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Transformer;

class ArticleTransformer extends TransformerAbstract
{
    /**
     * @var TagTransformer
     */
    private $tagTransformer;

    /**
     * @var Transformer\DateTimeTransformer
     */
    private $dateTimeTransformer;

    /**
     * @param Transformer\Entity\TagTransformer $tagTransformer
     * @param Transformer\DateTimeTransformer   $dateTimeTransformer
     */
    public function __construct(
        Transformer\Entity\TagTransformer $tagTransformer,
        Transformer\DateTimeTransformer $dateTimeTransformer
    ) {
        $this->tagTransformer = $tagTransformer;
        $this->dateTimeTransformer = $dateTimeTransformer;
    }

    /**
     * @param Entity\Article $article
     *
     * @return array
     */
    public function transform(Entity\Article $article)
    {
        $createdAt = $this->dateTimeTransformer->transform($article->getCreatedAt());
        $updatedAt = $this->dateTimeTransformer->transform($article->getUpdatedAt());

        return [
            'id' => $article->getId(),
            'slug' => $article->getSlug(),
            'title' => $article->getTitle(),
            'created_at' => $createdAt['formatted'],
            'updated_at' => $updatedAt['formatted'],
            'content' => $article->getContent(),
            'tags' => $this->serializeTags($article->getTags()),
            'active' => $article->getActive(),
        ];
    }

    /**
     * @param array $tags
     *
     * @return array
     */
    private function serializeTags(Collection $tags = null)
    {
        if ($tags === null) {
            return [];
        }

        $data = [];
        foreach ($tags as $tag) {
            $data[] = $this->tagTransformer->transform($tag);
        }

        return $data;
    }
}
