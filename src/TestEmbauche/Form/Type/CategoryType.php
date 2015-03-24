<?php

namespace TestEmbauche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text',array('label' => 'Post Category'))
            ->add('save', 'submit', array('label' => 'Enregistrer','attr' => array('class'=>'btn btn-primary')))
        ;
    }

    public function getName()
    {
        return 'category';
    }
}
