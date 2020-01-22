<?php
// src/App/Form/RegistrationType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('telnr');
        $builder->add('mobilenr');
        $builder->add('firstname');
        $builder->add('insertionname');
        $builder->add('lastname');
        $builder->add('adres');
        $builder->add('zip');
        $builder->add('city');
        $builder->add('country');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}
