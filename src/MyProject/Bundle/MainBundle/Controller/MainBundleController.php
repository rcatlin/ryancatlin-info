<?php

namespace MyProject\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainBundleController extends Controller
{
    /**
     * @return MyProject\Bundle\MainBundle\Entity\ArticleRepository
     */
    public function getArticleRepository()
    {
        return $this->getDefaultEntityManager()
            ->getRepository('MainBundle:Article')
        ;
    }

    /**
     * @return MyProject\Bundle\MainBundle\Entity\TagRepository
     */
    public function getTagRepository()
    {
        return $this->getDefaultEntityManager()
            ->getRepository('MainBundle:Tag')
        ;
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public function getDefaultEntityManager()
    {
        return $this->get(
            'doctrine.orm.default_entity_manager'
        );
    }
}
