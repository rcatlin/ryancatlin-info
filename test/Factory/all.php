<?php

namespace RCatlin\Test\Factory;

use League\FactoryMuffin\Facade as FactoryMuffin;
use RCatlin\Blog\Entity;

FactoryMuffin::define(Entity\Article::class, [
    'slug' => 'unique:word',
    'title' => 'text|255',
    'createdAt' => 'dateTimeBetween|-1 year;-1 day',
    'updatedAt' => 'dateTimebetween|-1 day;now',
    'content' => 'text',
    'active' => 'boolean',
    'tagCount' => 'numberBetween|0;2',
]);

FactoryMuffin::define(Entity\Tag::class, [
    'name' => 'unique:word',
]);

FactoryMuffin::setCustomSetter(function ($object, $name, $value) {
    if ($object instanceof Entity\Article) {
        switch ($name) {
            case 'slug':
                $object->setSlug($value);
                break;
            case 'title':
                $object->setTitle($value);
                break;
            case 'createdAt':
                $reflection = new \ReflectionObject($object);
                $property = $reflection->getProperty('createdAt');
                $property->setAccessible(true);
                $property->setValue($object, $value);
                break;
            case 'content':
                $object->setContent($value);
                break;
            case 'active':
                $object->setActive($value);
                break;
            case 'tagCount':
                $faker = FactoryMuffin::getFaker();

                $tags = [];

                for ($i = 0; $i < $faker->numberBetween(0, $value); $i++) {
                    $tags[] = FactoryMuffin::create(Entity\Tag::class);
                }

                $object->setTags($tags);
                break;
            case 'tags':
                $object->setTags($value);
                break;
        }

        return;
    }

    if ($object instanceof Entity\Tag) {
        switch ($name) {
            case 'name':
                $object->setName($name);
        }

        return;
    }

    $object->name = $value;
});

FactoryMuffin::setCustomMaker(function ($class) {
    if ($class === Entity\Article::class) {
        return Entity\Article::fromValues('slug', 'title', 'content', [], false);
    }

    if ($class == Entity\Tag::class) {
        return Entity\Tag::fromValues('name');
    }

    return new $class();
});
