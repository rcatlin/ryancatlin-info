<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use MyProject\Bundle\MainBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Article controller.
 *
 * @Route("/admin/articles")
 */
class ArticleController extends BaseController
{
    /**
     * Lists all Article entities.
     *
     * @Route("/", name="articles")
     * @Method("GET")
     * @Template("AdminBundle:Article:index.html.twig")
     */
    public function indexAction()
    {
        $entities = $this->getArticleRepository()->findAll();

        return [
            'entities' => $entities,
        ];
    }
}
