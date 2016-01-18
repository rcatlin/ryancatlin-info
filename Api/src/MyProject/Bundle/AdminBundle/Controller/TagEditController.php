<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use MyProject\Bundle\AdminBundle\Form\TagType;
use MyProject\Bundle\MainBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tag controller.
 *
 * @Route("/admin/tags")
 */
class TagEditController extends BaseController
{
    /**
     * Displays a form to edit an existing Tag entity.
     *
     * @Route("/{id}/edit", name="tags_edit")
     * @Method("GET")
     * @Template("AdminBundle:Tag:edit.html.twig")
     */
    public function editAction($id)
    {
        $entity = $this->getTagRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Edits an existing Tag entity.
     *
     * @Route("/{id}/edit", name="tags_update")
     * @Method("PUT")
     * @Template("AdminBundle:Tag:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->getTagRepository()->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDefaultEntityManager();
            $em->flush();

            return $this->redirect($this->generateUrl('tags_edit', ['id' => $id]));
        }

        return [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ];
    }

    /**
     * Creates a form to edit a Tag entity.
     *
     * @param Tag $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createEditForm(Tag $entity)
    {
        $form = $this->createForm(
            new TagType(),
            $entity,
            [
                'action' => $this->generateUrl(
                    'tags_update',
                    [
                        'id' => $entity->getId(),
                    ]
                ),
                'method' => 'PUT',
            ]
        );

        $form->add('submit', 'submit', ['label' => 'Update']);

        return $form;
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
