<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Show an Article Controller
 *
 * @Route("/admin/articles")
 */
class ArticleShowController extends BaseController
{
    /**
     * Finds and displays a Article entity.
     *
     * @Route("/{id}/show", name="article_show")
     * @Method("GET")
     * @Template("AdminBundle:Article:show.html.twig")
     */
    public function showAction($id)
    {
        $entity = $this->getArticleRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Creates a form to delete a Article entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'article_delete',
                    ['id' => $id]
                )
            )
            ->setMethod('DELETE')
            ->add(
                'submit',
                'submit',
                ['label' => 'Delete']
            )
            ->getForm()
        ;
    }
}
