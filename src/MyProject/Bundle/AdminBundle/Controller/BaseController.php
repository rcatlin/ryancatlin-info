<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
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
