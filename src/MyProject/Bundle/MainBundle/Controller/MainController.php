<?php

namespace MyProject\Bundle\MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends MainBundleController
{
    const LIMIT = 5;
    const TITLES_LIMIT = 10;

    /**
     * @Route("/", name="index")
     * @Template("MainBundle::index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $page = $this->getRequestPage($request);
        if ($page <= 0) {
            return $this->redirectToRoute('index');
        }

        $totalCount = ($this->getArticleRepository()->getActiveTotalCount());
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
    public function aboutAction(Request $request)
    {
        return array();
    }

    /**
     * @Route("/article/{slug}", name="article")
     * @Template("MainBundle::article.html.twig")
     */
    public function articleAction(Request $request, $slug)
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

        $page = $this->getRequestPage($request);
        if ($page <= 0) {
            $this->redirectToRoute('article_list');
        }

        $count = $this->getArticleRepository()->getActiveTotalCount();
        $numPages = $this->getNumPagesFromCount($count, 10);

        $articles = $this->getArticleRepository()
            ->findTitles(
                ($page - 1) * self::TITLES_LIMIT,
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

        $page = $this->getRequestPage($request);
        if ($page <= 0) {
            return $this->redirectToRoute('articles_by_tag', array('name' => $name));
        }

        if ($tag != null) {
            $numPages = $this->getNumPagesFromCount(
                $this->getArticleRepository()->getActiveTotalCountByTag($tag),
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

    protected function getRequestPage(Request $request)
    {
        if (!$request->query->has('p')) {
            return 1;
        }

        return $request->query->get('p');
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
