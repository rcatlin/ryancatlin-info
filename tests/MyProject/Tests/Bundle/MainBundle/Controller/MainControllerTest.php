<?php

namespace MyProject\Tests\Bundle\MainBundle\Controller;

use MyProject\Bundle\MainBundle\Controller\MainController;
use MyProject\Tests\Bundle\MainBundle\MainBundleTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class MainControllerTest extends MainBundleTestCase
{
    private $controller;
    private $container;
    private $articleRepo;
    private $tagRepo;

    protected function setUp()
    {
        $this->articleRepo = $this->buildMock('MyProject\Bundle\MainBundle\Entity\ArticleRepository');
        $this->tagRepo = $this->buildMock('MyProject\Bundle\MainBundle\Entity\TagRepository');

        $this->container = new Container();
        $this->container->set('article.repository', $this->articleRepo);
        $this->container->set('tag.repository', $this->tagRepo);

        $this->controller = new MainController();
        $this->controller->setContainer($this->container);
    }

    public function testIndexAction()
    {
        $request = new Request();
        $articles = $this->buildMock('Doctrine\ORM\Cursor');
        $numPages = 2;
        $totalCount = MainController::LIMIT * $numPages;

        // Expectations
        $this->articleRepo->expects($this->once())
            ->method('getActiveTotalCount')
            ->willReturn($totalCount)
        ;
        $this->articleRepo->expects($this->once())
            ->method('findAllActiveArticles')
            ->with(0, MainController::LIMIT)
            ->willReturn($articles)
        ;

        // Call test method
        $response = $this->controller->indexAction($request);

        // Assertions
        $this->assertEquals(
            array(
                'articles' => $articles,
                'page' => 1,
                'numPages' => $numPages,
            ),
            $response
        );
    }

    public function testAboutAction()
    {
        $request = new Request();

        $this->assertEquals(
            array(),
            $this->controller->aboutAction($request)
        );
    }

    public function testArticleAction()
    {
        $request = new Request();
        $name = 'article name';
        $article = $this->buildMock('MyProject\Bundle\MainBundle\Entity\Article');

        // Expectations
        $this->articleRepo->expects($this->once())
            ->method('findActiveBySlug')
            ->willReturn($article)
        ;

        // Call test method
        $response = $this->controller->articleAction($request, $name);

        // Assertions
        $this->assertEquals(
            array(
                'article' => $article,
            ),
            $response
        );
    }

    public function testListArticlesActin()
    {
        $request = new Request();
        $numPages = 4;
        $totalCount = MainController::TITLES_LIMIT * $numPages;
        $articles = $this->buildMock('Doctrine\ORM\Cursor');

        // Expectations
        $this->articleRepo->expects($this->once())
            ->method('getActiveTotalCount')
            ->willReturn($totalCount)
        ;
        $this->articleRepo->expects($this->once())
            ->method('findTitles')
            ->with(0, MainController::TITLES_LIMIT)
            ->willReturn($articles)
        ;

        // Call test method
        $response = $this->controller->listArticlesAction($request);

        // Assertions
        $this->assertEquals(
            array(
                'articles' => $articles,
                'page' => 1,
                'numPages' => $numPages,
                'count' => $totalCount,
            ),
            $response
        );
    }

    public function testArticlesByTagAction()
    {
        $numPages = 10;
        $name = 'tag name';
        $request = new Request();
        $articles = $this->buildMock('Doctrine\ORM\Cursor');
        $tag = $this->buildMock('MyProject\Bundle\MainBundle\Entity\Tag');
        $numPages = 2;
        $totalCount = MainController::LIMIT * $numPages;

        // Expectations
        $this->tagRepo->expects($this->once())
            ->method('findOneByName')
            ->with($name)
            ->willReturn($tag)
        ;

        $this->articleRepo->expects($this->once())
            ->method('getActiveTotalCountByTag')
            ->with($tag)
            ->willReturn($totalCount)
        ;

        $this->articleRepo->expects($this->once())
            ->method('findActiveByTag')
            ->with(
                $tag,
                0,
                MainController::LIMIT
            )
            ->willReturn($articles)
        ;

        // Call test method
        $response = $this->controller->articlesByTagAction($request, $name);

        // Asssetions
        $this->assertEquals(
            array(
                'articles' => $articles,
                'page' => 1,
                'numPages' => $numPages,
            ),
            $response
        );
    }
}
