<?php

namespace MyProject\Tests\Bundle\APIBundle\Controller;

use MyProject\Tests\Bundle\APIBundle\APIBundleTestCase;
use MyProject\Bundle\APIBundle\Controller\TagController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;

class TagControllerTest extends APIBundleTestCase
{
    private $tagRepo;
    private $container;
    private $controller;

    protected function setUp()
    {
        $this->tagRepo = $this->buildMock('MyProject\Bundle\MainBundle\Entity\TagRepository');

        $this->container = new Container();
        $this->container->set('tag.repository', $this->tagRepo);

        $this->controller = new TagController();
        $this->controller->setContainer($this->container);
    }
    public function testListAllNamesAction()
    {
        $this->tagRepo->expects($this->once())
            ->method('findAllNames')
            ->will(
                $this->returnValue(
                    array(
                        array(
                            'name' => 'Triangulum',
                        ),
                        array(
                            'name' => 'Andromeda',
                        ),
                    )
                )
            )
        ;

        $result = $this->controller->listAllNamesAction();

        $this->assertTrue(
            $result instanceof Response
        );

        $this->assertEquals(
            '["Triangulum","Andromeda"]',
            $result->getContent()
        );
    }
}
