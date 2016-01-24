<?php

namespace MyProject\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MainBundleController extends Controller
{
    /**
     * Returns a RedirectResponse to the given route.
     *
     * @param string      $route         The name of the route
     * @param mixed       $parameters    An array of parameters
     * @param bool|string $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     * @param int         $status        The status code to use for the Response
     *
     * @return RedirectResponse
     */
    public function redirectToRoute(
        $route,
        $parameters = [],
        $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH,
        $status = 302
    ) {
        return $this->redirect(
            $this->generateUrl(
                $route,
                $parameters,
                $referenceType
            ),
            $status
        );
    }

    /**
     * @return MyProject\Bundle\MainBundle\Entity\ArticleRepository
     */
    public function getArticleRepository()
    {
        return $this->get('article.repository');
    }

    /**
     * @return MyProject\Bundle\MainBundle\Entity\TagRepository
     */
    public function getTagRepository()
    {
        return $this->get('tag.repository');
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
