<?php

namespace MyProject\Bundle\AdminBundle\Controller;

use MyProject\Bundle\AdminBundle\Form\ArticleType;
use MyProject\Bundle\MainBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * Article Creation Controller
 *
 * @Route("/admin/articles")
 */
class ArticleCreateController extends BaseController
{
    /**
     * Creates a new Article entity.
     *
     * @Route("/create", name="article_create")
     * @Method("POST")
     * @Template("AdminBundle:Article:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Article();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDefaultEntityManager();

            // Get new tags
            $newTagsData = $form->get('new_tags')->getData();
            $newTags = $newTagsData->toArray();

            if (!empty($newTags)) {
                // Persist the new tags
                foreach ($newTags as $tag) {
                    $em->persist($tag);
                }

                // Add tags to article
                if ($newTags !== null) {
                    $entity->addTags($newTags);
                }
            }

            // Persist article
            $em->persist($entity);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'article_show',
                    ['id' => $entity->getId()]
                )
            );
        }

        return [
            'entity' => $entity,
            'form' => $form->createView(),
        ];
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="article_new")
     * @Method("GET")
     * @Template("AdminBundle:Article:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Article();
        $form = $this->createCreateForm($entity);

        return $this->render(
            'AdminBundle:Article:new.html.twig',
            [
                'entity' => $entity,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Creates a form to create a Article entity.
     *
     * @param Article $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Article $entity)
    {
        $form = $this->createForm(
            new ArticleType(),
            $entity,
            [
                'action' => $this->generateUrl('article_create'),
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
