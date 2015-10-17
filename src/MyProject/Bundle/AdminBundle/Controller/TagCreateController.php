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
class TagCreateController extends BaseController
{
    /**
     * Displays a form to create a new Tag entity.
     *
     * @Route("/new", name="tag_new")
     * @Method("GET")
     * @Template("AdminBundle:Tag:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Tag();
        $form = $this->createCreateForm($entity);

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a new Tag entity.
     *
     * @Route("/create", name="tags_create")
     * @Method("POST")
     * @Template("AdminBundle:Tag:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tag();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDefaultEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'tags_show',
                    [
                        'id' => $entity->getId(),
                    ]
                )
            );
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Creates a form to create a Tag entity.
     *
     * @param Tag $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tag $entity)
    {
        $form = $this->createForm(
            new TagType(),
            $entity,
            [
                'action' => $this->generateUrl('tags_create'),
                'method' => 'POST',
            ]
        );

        $form->add(
            'submit',
            'submit',
            ['label' => 'Create']
        );

        return $form;
    }
}
