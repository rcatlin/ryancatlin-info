<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tag controller.
 *
 * @Route("/admin/tags")
 */
class TagDeleteController extends BaseController
{
    /**
     * Deletes a Tag entity.
     *
     * @Route("/{id}", name="tags_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDefaultEntityManager();
            $entity = $this->getTagRepository()->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tag entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tags'));
    }

    /**
     * Creates a form to delete a Tag entity by id.
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
                    'tags_delete',
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
