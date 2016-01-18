<?php

namespace RCatlin\Blog\Test\Unit\Controller\Api;

use Doctrine\ORM\EntityManager;
use RCatlin\Blog\Controller;
use RCatlin\Blog\Entity;
use RCatlin\Blog\Repository;
use RCatlin\Blog\Test\HasFaker;
use RCatlin\Blog\Test\Unit\BuildsMocks;
use Refinery29\Piston\Request;
use Refinery29\Piston\Response;
use Teapot\StatusCode;

class TagDeleteControllerTest extends \PHPUnit_Framework_TestCase
{
    use BuildsMocks;
    use HasFaker;

    public function testDelete()
    {
        $id = $this->getFaker()->randomNumber();

        $tag = $this->getMockTag();

        $entityManager = $this->getMockEntityManager();
        $entityManager->expects($this->once())
            ->method('remove')
            ->with($tag)
        ;
        $entityManager->expects($this->once())
            ->method('flush')
        ;

        $tagRepository = $this->getMockTagRepository();
        $tagRepository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn($tag)
        ;

        $controller = new Controller\Api\TagDeleteController($entityManager, $tagRepository);

        $response = $controller->delete(new Request(), new Response(), ['id' => $id]);

        $this->assertEquals(StatusCode::NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteWithBadId()
    {
        $id = $this->getFaker()->randomNumber();

        $tagRepository = $this->getMockTagRepository();
        $tagRepository->expects($this->once())
            ->method('find')
            ->with($id)
            ->willReturn(null)
        ;

        $controller = new Controller\Api\TagDeleteController($this->getMockEntityManager(), $tagRepository);

        $response = $controller->delete(new Request(), new Response(), ['id' => $id]);

        $this->assertEquals(StatusCode::NOT_FOUND, $response->getStatusCode());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|EntityManager
     */
    private function getMockEntityManager()
    {
        return $this->buildMock(EntityManager::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Repository\TagRepository
     */
    private function getMockTagRepository()
    {
        return $this->buildMock(Repository\TagRepository::class);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Entity\Tag
     */
    private function getMockTag()
    {
        return $this->buildMock(Entity\Tag::class);
    }
}
