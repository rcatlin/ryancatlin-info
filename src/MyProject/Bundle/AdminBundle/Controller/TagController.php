<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Tag controller.
 *
 * @Route("/admin/tags")
 */
class TagController extends BaseController
{
    /**
     * Lists all Tag entities.
     *
     * @Route("/", name="tags")
     * @Method("GET")
     * @Template("AdminBundle:Tag:index.html.twig")
     */
    public function indexAction()
    {
        $entities = $this->getTagRepository()->findAll();

        return array(
            'entities' => $entities,
        );
    }
}
