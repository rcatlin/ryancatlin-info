<?php

namespace RCatlin\Blog\Test\Unit\Validator\Entity;

use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Validator\Context;
use RCatlin\Blog\Validator\Entity\ArticleValidator;
use RCatlin\Blog\Validator\Entity\TagValidator;

class ArticleValidatorUpdateContextTest extends \PHPUnit_Framework_TestCase
{
    use HasFaker;

    public function testIsValid()
    {
        $validator = new ArticleValidator(new TagValidator());

        $validationResult = $validator->validate($this->getAllValues(), Context::CREATE);

        $this->assertTrue($validationResult->isValid());
    }

    private function getAllValues()
    {
        $faker = $this->getFaker();

        return [
            'slug' => $faker->word,
            'title' => $faker->sentence(),
            'content' => $faker->paragraph,
            'tags' => [
                ['name' => $faker->word],
                ['name' => $faker->word],
            ],
            'active' => $faker->boolean(),
        ];
    }
}
