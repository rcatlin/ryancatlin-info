<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use MyProject\Bundle\MainBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MainBundle:Article')->findAll();

        return $this->render('AdminBundle:Article:index.html.twig', array(
            'entities' => $entities,
        ));
    }
}
