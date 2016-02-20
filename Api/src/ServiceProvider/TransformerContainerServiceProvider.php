<?php

namespace RCatlin\Api\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Api\Transformer;

class TransformerContainerServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Transformer\TransformerContainer::class,
    ];

    /**
     * {inheritDoc}
     */
    public function register()
    {
        $this->getContainer()->share(Transformer\TransformerContainer::class);
    }
}
