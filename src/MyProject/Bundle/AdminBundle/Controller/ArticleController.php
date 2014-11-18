<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use MyProject\Bundle\MainBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Article controller.
 *
 * @Route("/admin/articles")
 */
class ArticleController extends Controller
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
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MainBundle:Article')->findAll();

        return array(
            'entities' => $entities,
        );
    }
}
