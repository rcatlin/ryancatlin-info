<?php

namespace RCatlin\Blog\Test\Integration\ServiceProvider;

use RCatlin\Blog\ServiceProvider;
use RCatlin\Blog\Validator;

class ValidatorServiceProviderTest extends AbstractServiceProviderTest
{
    /**
     * {inheritDoc}
     */
    public function getServiceProviders()
    {
        return [
            new ServiceProvider\ValidatorServiceProvider(),
        ];
    }

    /**
     * {inheritDoc}
     */
    public function providesDataProvider()
    {
        return [
            [Validator\Entity\ArticleValidator::class, Validator\Entity\ArticleValidator::class],
            [Validator\Entity\TagValidator::class, Validator\Entity\TagValidator::class],
        ];
    }
}
