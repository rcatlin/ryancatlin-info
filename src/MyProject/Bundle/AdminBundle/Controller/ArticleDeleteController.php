<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Delete an Article
 *
 * @Route("/admin/articles")
 */
class ArticleDeleteController extends Controller
{
    /**
     * Deletes a Article entity.
     *
     * @Route("/{id}/delete", name="article_delete")
     * @Method({"POST","DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MainBundle:Article')->find($id);

        if ($form->isValid() && $entity !== null) {
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Article entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect(
            $this->generateUrl(
                'articles'
            )
        );
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
                    array('id' => $id)
                )
            )
            ->setMethod('DELETE')
            ->add(
                'submit',
                'submit',
                array('label' => 'Delete')
            )
            ->getForm()
        ;
    }
}
