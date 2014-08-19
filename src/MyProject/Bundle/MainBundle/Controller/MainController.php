<?php

namespace MyProject\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return new Response('Hello, galaxy!', 200);
    }
}
