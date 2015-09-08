<?php

namespace RCatlin\Blog\Serializer\Transformer\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use League\Fractal\TransformerAbstract;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Serializer\Transformer\DateTimeTransformer;

class ArticleTransformer extends TransformerAbstract
{
    /**
     * @param Entity\Article $article
     *
     * @return array
     */
    public function transformer(Entity\Article $article)
    {
        $dateTimeTransformer = new DateTimeTransformer();

        $createdAt = $dateTimeTransformer->transform($article->getCreatedAt());
        $updatedAt = $dateTimeTransformer->transform($article->getUpdatedAt());

        return [
            'id' => (int) $article->getId(),
            'slug' => (string) $article->getSlug(),
            'title' => (string) $article->getTitle(),
            'created_at' => (string) $createdAt['formatted'],
            'updated_at' => (string) $updatedAt['formatted'],
            'content' => (string) $article->getContent(),
            'tags' => $this->serializeTags($article->getTags()),
            'active' => (bool) $article->getActive(),
        ];
    }

    /**
     * @param array $tags
     *
     * @return array
     */
    private function serializeTags(ArrayCollection $tags = null)
    {
        if ($tags === null) {
            return [];
        }

        $data = [];
        $transformer = new TagTransformer();

        foreach ($tags as $tag) {
            $data[$tag->getId()] = $transformer->transform($tag);
        }

        return $data;
    }
}
