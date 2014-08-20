<?php

namespace MyProject\Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template("MainBundle::index.html.twig")
     */
    public function indexAction()
    {
        return array(
            'message' => 'Hello, universe! We are still in progress.'
        );
    }

    /**
     * @Route("/hello/{name}", name="hello")
     */
    public function helloAction($name)
    {
        return new Response(
            sprintf(
                'Hello there, %s!',
                ucfirst($name)
            ),
            200
        );
    }

    /**
     * @Route("/about", name="about")
     * @Template("MainBundle::about.html.twig")
     */
    public function aboutAction()
    {
        return array();
    }
}
