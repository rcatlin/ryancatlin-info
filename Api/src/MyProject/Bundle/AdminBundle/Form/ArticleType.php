<?php

namespace MyProject\Bundle\AdminBundle\Form;

use MyProject\Bundle\AdminBundle\Form\DataTransformer\NewTagsTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('title')
            ->add(
                'active',
                'checkbox',
                [
                    'required' => false,
                ]
            )
            ->add(
                $builder->create(
                    'createdAt',
                    'hidden'
                )
                ->addViewTransformer(new DateTimeToStringTransformer())
            )
            ->add(
                $builder->create(
                    'updatedAt',
                    'hidden'
                )
                ->addViewTransformer(new DateTimeToStringTransformer())
            )
            ->add(
                'prettyContent',
                'textarea',
                [
                    'required' => false,
                    'mapped' => false,
                    'label' => 'Content', // False Content Input
                ]
            )
            ->add(
                'tags_autocomplete',
                'text',
                [
                    'required' => false,
                    'mapped' => false,
                ]
            )
            ->add(
                'tags',
                'entity',
                [
                    'class' => 'MainBundle:Tag',
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                ]
            )
            ->add(
                $builder->create(
                    'new_tags',
                    'hidden',
                    [
                        'required' => false,
                        'mapped' => false,
                    ]
                )->addModelTransformer(new NewTagsTransformer())
            )
            ->add(
                $builder->create(
                    'content',
                    'hidden'
                )
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'data_class' => 'MyProject\Bundle\MainBundle\Entity\Article',
                ]
            )
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'article';
    }
}
