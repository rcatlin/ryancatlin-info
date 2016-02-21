<?php

namespace RCatlin\Api\Controller\Api;

use League\Fractal\Scope;
use RCatlin\Api\Behavior;
use RCatlin\Api\Entity;
use RCatlin\Api\Serializer;

class AbstractTagController
{
    use Behavior\RenderError;
    use Behavior\RenderResponse;

    /**
     * @var Serializer\ScopeBuilder
     */
    private $scopeBuilder;

    /**
     * @param Serializer\ScopeBuilder $scopeBuilder
     */
    public function __construct(Serializer\ScopeBuilder $scopeBuilder)
    {
        $this->scopeBuilder = $scopeBuilder;
    }

    /**
     * @param Entity\Tag $tag
     *
     * @return Scope
     */
    protected function getTagScope(Entity\Tag $tag)
    {
        return $this->scopeBuilder->buildItem(Entity\Tag::class, $tag);
    }
}
