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
            ->add('name', 'textarea',array('label' => 'Post Category'));
    }

    public function getName()
    {
        return 'category';
    }
}
