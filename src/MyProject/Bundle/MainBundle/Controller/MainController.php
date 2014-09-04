<?php

namespace MyProject\Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends MainBundleController
{
    const LIMIT = 10;

    /**
     * @Route("/", name="index")
     * @Template("MainBundle::index.html.twig")
     */
    public function indexAction(Request $request)
    {
        // Get page query parameter
        $page = ($request->query->has('p')) ? $request->query->get('p') : 0;

        // Get Articles
        $articles = $this->getArticleRepository()
            ->findArticles(
                $page * self::LIMIT,
                self::LIMIT
            )
        ;

        // Pass variables to template
        return array(
            'articles' => $articles,
            'page' => $page
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

    /**
     * @Route("/article/{slug}", name="article")
     * @Template("MainBundle::article.html.twig")
     */
    public function articleAction($slug)
    {
        $article = $this->getArticleRepository()
            ->findBySlug($slug)
        ;

        return array(
            'article' => $article
        );
    }

    /**
     * @Route("/tag/{name}", name="articles_by_tag")
     * @Template("MainBundle::index.html.twig")
     */
    public function articlesByTagAction(Request $request, $name)
    {
        $tag = $this->getTagRepository()->findOneByName($name);

        $page = $request->query->has('p') ? $request->query->get('q') : 0;

        $articles = $this->getArticleRepository()
            ->findByTag(
                $tag,
                $page * self::LIMIT,
                self::LIMIT
            )
        ;

        return array(
            'articles' => $articles,
            'page' => $page
        );
    }
}
