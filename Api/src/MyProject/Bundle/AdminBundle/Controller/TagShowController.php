<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Tag controller.
 *
 * @Route("/tags")
 */
class TagShowController extends BaseController
{
    /**
     * Finds and displays a Tag entity.
     *
     * @Route("/{id}", name="tags_show")
     * @Method("GET")
     * @Template("AdminBundle:Tag:show.html.twig")
     */
    public function showAction($id)
    {
        $entity = $this->getTagRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
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
