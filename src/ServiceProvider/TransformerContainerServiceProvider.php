<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Serializer;

class TransformerContainerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Serializer\TransformerContainer::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $this->getContainer()->share(Serializer\TransformerContainer::class);
    }
}
