<?php

namespace TestEmbauche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text',array('label' => 'Titre', 'attr' => array('class'=>'form-control')))
            ->add('content', 'textarea',array('label' => 'Contenu', 'attr' => array('class'=>'form-control')))
            ->add('category', 'choice', array('choices' => $options['data'], 'attr' => array('class'=>'form-control')))
            ->add('save', 'submit', array('label' => 'Enregistrer','attr' => array('class'=>'btn btn-primary')))
        ;
    }

    public function getName()
    {
        return 'article';
    }
}
