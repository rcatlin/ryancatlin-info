<?php

namespace MyProject\Tests\Bundle\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use MyProject\Bundle\MainBundle\Entity\Article;
use MyProject\Tests\Bundle\MainBundle\MainBundleTestCase;

class ArticleTest extends MainBundleTestCase
{
    public function testSettersAndGettings()
    {
        $date = new \DateTime();
        $date->setTimestamp(1234567890);

        // Create test object
        $article = new Article();

        // Id
        $this->assertNull($article->getId());

        // Slug
        $article->setSlug('article slug');
        $this->assertEquals(
            'article slug',
            $article->getSlug()
        );

        // Title
        $article->setTitle('Grandiose Title');
        $this->assertEquals(
            'Grandiose Title',
            $article->getTitle()
        );

        // CreatedAt
        $this->assertNotNull($article->getCreatedAt());
        $article->setCreatedAt($date);
        $this->assertEquals(
            1234567890,
            $article->getCreatedAt()->getTimestamp()
        );

        // UpdatedAt
        $this->assertNotNull($article->getUpdatedAt());
        $article->setUpdatedAt($date);
        $this->assertEquals(
            1234567890,
            $article->getUpdatedAt()->getTimestamp()
        );

        // Content
        $article->setContent('Spectacular show of content.');
        $this->assertEquals(
            'Spectacular show of content.',
            $article->getContent()
        );

        // Tags
        $this->assertTrue($article->getTags() instanceof ArrayCollection);
        $this->assertEquals(// initially empty
            0,
            $article->getTags()->count()
        );
        $article->addTags(array('2'));
        $this->assertEquals(
            array('2'),
            $article->getTags()->toArray()
        );
        $article->addTags(array('6', '0'));
        $this->assertEquals(
            array('2', '6', '0'),
            $article->getTags()->toArray()
        );

        // Active
        $this->assertFalse($article->getActive());
        $article->setActive(true);
        $this->assertTrue($article->getActive());
    }
}
