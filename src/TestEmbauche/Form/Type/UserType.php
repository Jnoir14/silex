<?php

namespace TestEmbauche\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text')
            ->add('password', 'repeated', array(
                'type'            => 'password',
                'options'         => array('required' => false),
                'first_options'   => array('label' => 'Password'),
                'second_options'  => array('label' => 'Repeat Password'),
                'required' => FALSE,
            ))
            ->add('mail', 'email')
            ->add('role', 'choice', array(
                'choices' => array('ROLE_USER' => 'User')
            ))
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'user';
    }
}
