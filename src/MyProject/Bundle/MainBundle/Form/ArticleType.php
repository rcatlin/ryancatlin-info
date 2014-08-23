<?php

namespace MyProject\Bundle\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug')
            ->add('title')
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
            ->add('content')
            ->add(
                'tags',
                null,
                array('required' => false)
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyProject\Bundle\MainBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'myproject_bundle_mainbundle_article';
    }
}
