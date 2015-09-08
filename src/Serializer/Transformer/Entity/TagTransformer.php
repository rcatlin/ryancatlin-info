<?php

namespace RCatlin\Blog\Serializer\Transformer\Entity;

use League\Fractal\TransformerAbstract;
use RCatlin\Blog\Entity;

class TagTransformer extends TransformerAbstract
{
    /**
     * @param Entity\Tag $tag
     *
     * @return array
     */
    public function transform(Entity\Tag $tag)
    {
        return [
            'id' => (int) $tag->getId(),
            'name' => (string) $tag->getName(),
        ];
    }
}
