<?php

namespace RCatlin\Api\Test\Unit\Controller\Api;

use League\Fractal\Scope;
use RCatlin\Api\Controller;
use RCatlin\Api\Entity;
use RCatlin\Api\Repository;
use RCatlin\Api\Serializer;
use RCatlin\Api\Test\HasFaker;
use RCatlin\Api\Test\ReadsResponseContent;
use RCatlin\Api\Test\Unit\BuildsMocks;
use Refinery29\Piston\ApiResponse;
use Refinery29\Piston\Request;
use Teapot\StatusCode;

class ArticleGetControllerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;
    use ReadsResponseContent;

    public function testGetFindsArticleById()
    {
        $id = $this->getFaker()->randomNumber();
        $serializedArticle = ['serialized-article'];

        $article = $this->getMockArticle();
        $scope = $this->getMockScope();

        $scopeBuilder = $this->getMockScopeBuilder();
        $scopeBuilder->expects($this->once())
            ->method('buildItem')
            ->with(Entity\Article::class, $article)
            ->willReturn($scope)
        ;

        $scope->expects($this->once())
            ->method('toArray')
            ->willReturn($serializedArticle)
        ;

        $repo = $this->getMockArticleRepository();
        $repo->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($article)
        ;

        $controller = new Controller\Api\ArticleGetController($repo, $scopeBuilder, $this->getMockTagRepository());

        $response = $controller->get(new Request(), new ApiResponse(), ['id' => $id]);

        $this->assertEquals(StatusCode::OK, $response->getStatusCode());

        $content = $this->readControllerResponse($response);

        $this->assertEquals(json_encode([
            'result' => $serializedArticle,
        ]), $content);
    }

    public function testGetDoesNotFindAnArticle()
    {
        $id = $this->getFaker()->randomNumber();

        $repo = $this->getMockArticleRepository();
        $repo->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null)
        ;

        $controller = new Controller\Api\ArticleGetController(
            $repo,
            $this->getMockScopeBuilder(),
            $this->getMockTagRepository()
        );

        $response = $controller->get(new Request(), new ApiResponse(), ['id' => $id]);

        $this->assertEquals(StatusCode::NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Repository\ArticleRepository
     */
    private function getMockArticleRepository()
    {
        return $this->buildMock(Repository\ArticleRepository::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Repository\TagRepository
     */
    private function getMockTagRepository()
    {
        return $this->buildMock(Repository\TagRepository::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Serializer\ScopeBuilder
     */
    private function getMockScopeBuilder()
    {
        return $this->buildMock(Serializer\ScopeBuilder::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Article
     */
    private function getMockArticle()
    {
        return $this->buildMock(Entity\Article::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Scope
     */
    private function getMockScope()
    {
        return $this->buildMock(Scope::class);
    }
}
