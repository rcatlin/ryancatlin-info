<?php

namespace MyProject\Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends MainBundleController
{
    const LIMIT = 5;

    /**
     * @Route("/", name="index")
     * @Template("MainBundle::index.html.twig")
     */
    public function indexAction(Request $request)
    {
        // Get page query parameter
        $page = ($request->query->has('p')) ? $request->query->get('p') : 1;
        $totalCount = ($this->getArticleRepository()->getTotalCount());
        $numPages = $this->getNumPagesFromCount($totalCount, self::LIMIT);

        // Get Articles
        $articles = $this->getArticleRepository()
            ->findAllActiveArticles(
                ($page - 1) * self::LIMIT,
                self::LIMIT
            )
        ;

        // Pass variables to template
        return array(
            'articles' => $articles,
            'page' => $page,
            'numPages' => $numPages,
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
            ->findActiveBySlug($slug)
        ;

        return array(
            'article' => $article,
        );
    }

    /**
     * @Route("articles", name="article_list")
     * @Template("MainBundle::article_list.html.twig")
     */
    public function listArticlesAction(Request $request)
    {
        $limit = 10;
        $page = $request->query->has('p') ? $request->query->get('p') : 1;

        $count = $this->getArticleRepository()->getTotalCount();
        $numPages = $this->getNumPagesFromCount($count, 10);

        $articles = $this->getArticleRepository()
            ->findTitles(
                ($page - 1) * 10,
                10
            );

        return array(
            'articles' => $articles,
            'page' => $page,
            'numPages' => $numPages,
            'count' => $count,
        );
    }

    /**
     * @Route("/tag/{name}", name="articles_by_tag")
     * @Template("MainBundle::index.html.twig")
     */
    public function articlesByTagAction(Request $request, $name)
    {
        $tag = $this->getTagRepository()->findOneByName($name);

        $page = $request->query->has('p') ? $request->query->get('q') : 1;

        if ($tag != null) {
            $numPages = $this->getNumPagesFromCount(
                $this->getArticleRepository()->getTotalCountByTag($tag),
                self::LIMIT
            );
        } else {
            $numPages = 0;
        }

        $articles = $this->getArticleRepository()
            ->findActiveByTag(
                $tag,
                ($page - 1) * self::LIMIT,
                self::LIMIT
            )
        ;

        return array(
            'articles' => $articles,
            'page' => $page,
            'numPages' => $numPages,
        );
    }

    protected function getNumPagesFromCount($count, $limit)
    {
        if ($count < $limit) {
            return 1;
        }

        return intval(
            ceil($count / $limit)
        );
    }
}
