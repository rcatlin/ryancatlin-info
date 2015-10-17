<?php

namespace RCatlin\Blog\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\Blog\Validator;

class ValidatorServiceProvider extends AbstractServiceProvider
{
    /**
     * {inheritDoc}
     */
    public function register()
    {
        $container = $this->getContainer();

        $container->share(Validator\Entity\ArticleValidator::class);
        $container->share(Validator\Entity\TagValidator::class);
    }
}
