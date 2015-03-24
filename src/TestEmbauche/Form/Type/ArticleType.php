<?php

namespace TestEmbauche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data = $builder->getData();
        $builder
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->add('category', 'choice', array('choices' => $data->getCategoryAll()))
            ->add('save', 'submit', array('label' => 'Enregistrer','attr' => array('class'=>'btn btn-primary')))
        ;
    }

    public function getName()
    {
        return 'article';
    }
}
