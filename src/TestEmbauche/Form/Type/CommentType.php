<?php

namespace TestEmbauche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', 'textarea', array(
                'label' => '',
            ))
            ->add('save', 'submit', array(
                'label' => 'Post Comment',
                'attr' => array('class' => 'btn btn-inverse'),
            ));
    }

    public function getName()
    {
        return 'comment';
    }
}
