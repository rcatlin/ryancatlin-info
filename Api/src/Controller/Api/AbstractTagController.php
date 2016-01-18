<?php

namespace RCatlin\Blog\Controller\Api;

use League\Fractal\Scope;
use RCatlin\Blog\Behavior;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Serializer;

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
