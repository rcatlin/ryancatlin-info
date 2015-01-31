<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use MyProject\Bundle\AdminBundle\Form\ArticleType;
use MyProject\Bundle\MainBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Edit an Article Controller
 *
 * @Route("/admin/articles")
 */
class ArticleEditController extends BaseController
{
    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Method("GET")
     * @Template("AdminBundle:Article:edit.html.twig")
     */
    public function editAction($id)
    {
        $entity = $this->getArticleRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{id}/update", name="article_update")
     * @Method({"POST","PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getArticleRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDefaultEntityManager();

            // Get new tags
            $newTags = $editForm->get('new_tags')->getData();

            if ($newTags->count() > 0) {
                // Persist the new tags
                foreach ($newTags as $tag) {
                    $em->persist($tag);
                }

                // Add tags to article
                if ($newTags !== null) {
                    $entity->addTags($newTags);
                }
            }

            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'article_show',
                    array('id' => $id)
                )
            );
        }

        return $this->render(
            'AdminBundle:Article:edit.html.twig',
            array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
    * Creates a form to edit a Article entity.
    *
    * @param Article $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Article $entity)
    {
        $form = $this->createForm(
            new ArticleType(),
            $entity,
            array(
                'action' => $this->generateUrl(
                    'article_update',
                    array('id' => $entity->getId())
                ),
                'method' => 'PUT',
            )
        );

        $form->add(
            'submit',
            'submit',
            array('label' => 'Update')
        );

        return $form;
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
