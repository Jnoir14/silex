<?php

namespace TestEmbauche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Pas top (a modifier) manque de fetchAssoc :(
        $data= array();
        foreach ($options['data'] as $dataRows){
            $data +=array($dataRows['id'] => $dataRows['name']);
        }
        $builder
            ->add('title', 'text',array('label' => 'Titre', 'attr' => array('class'=>'form-control')))
            ->add('content', 'textarea',array('label' => 'Contenu', 'attr' => array('class'=>'form-control')))
            ->add('category', 'choice', array('choices' => $data, 'attr' => array('class'=>'form-control')))
        ;
    }

    public function getName()
    {
        return 'article';
    }
}
