<?php

namespace MyProject\Tests\Bundle\AdminBundle\Controller;

use MyProject\Bundle\AdminBundle\Controller\ArticleController;
use MyProject\Tests\Bundle\AdminBundle\AdminBundleTestCase;
use Symfony\Component\DependencyInjection\Container;

class ArticleControllerTest extends AdminBundleTestCase
{
    private $controller;
    private $articleRepo;
    private $container;

    protected function setUp()
    {
        $this->articleRepo = $this->buildMock(
            'MyProject\Bundle\MainBundle\Entity\ArticleRepository'
        );

        // Setup Container
        $this->container = new Container();
        $this->container->set('article.repository', $this->articleRepo);

        // Setup ArticleController
        $this->controller = new ArticleController();
        $this->controller->setContainer($this->container);
    }

    public function testIndexAction()
    {
        $entities = $this->buildMock('Doctrine\DBAL\Driver\Statement');

        $this->articleRepo->expects($this->once())
            ->method('findAll')
            ->will(
                $this->returnValue($entities)
            )
        ;

        $result = $this->controller->indexAction();

        $this->assertEquals(
            $result,
            array(
                'entities' => $entities,
            )
        );
    }
}
