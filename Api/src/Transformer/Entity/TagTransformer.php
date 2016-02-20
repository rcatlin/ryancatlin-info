<?php

namespace RCatlin\Api\Transformer\Entity;

use League\Fractal\TransformerAbstract;
use RCatlin\Api\Entity;

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
            'id' => $tag->getId(),
            'name' => $tag->getName(),
        ];
    }
}
