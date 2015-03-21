<?php

namespace TestEmbauche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class WorkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Titre', 'attr' => array('class'=>'form-control')))
            ->add('content', 'text', array('label' => 'Contenu', 'attr' => array('class'=>'form-control')))
            ->add('file', 'file', array(
                'label' => 'Image',
            ))
            ->add('save', 'submit', array('label' => 'Enregistrer','attr' => array('class'=>'btn btn-primary')))
        ;
    }

    public function getName()
    {
        return 'work';
    }
}
