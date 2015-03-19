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
            ->add('title', 'text',array('label' => 'Post Article'))
            ->add('content', 'textarea',array('label' => 'Post Article'))
            ->add('category', 'choice', array(
            'choices' => $data
            ));
    }

    public function getName()
    {
        return 'article';
    }
}
