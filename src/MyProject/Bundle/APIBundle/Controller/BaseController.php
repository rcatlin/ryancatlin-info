<?php

namespace MyProject\Bundle\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    /**
     * @param array $data
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    protected function returnJson(array $data)
    {
        return new Response(
            json_encode($data),
            Response::HTTP_OK,
            [
                'Content-type' => 'application/json',
            ]
        );
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    protected function getDefaultEntityManager()
    {
        return $this->get('doctrine.orm.default_entity_manager');
    }

    protected function getArticleRepository()
    {
        return $this->get('article.repository');
    }

    protected function getTagRepository()
    {
        return $this->get('tag.repository');
    }
}
