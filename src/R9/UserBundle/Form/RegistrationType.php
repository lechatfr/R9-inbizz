<?php
// src/AppBundle/Form/RegistrationType.php

namespace R9\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array('required' => true))
            ->add('plainPassword', TextType::class, array('required' => true))
            ->add('nom', TextType::class, array('required' => false))
            ->add('prenom', TextType::class, array('required' => false))
            ->add('agence', TextType::class, array('required' => false))
            ->add('facebook', TextType::class, array('required' => false))
            ->add('tel', TextType::class, array('required' => false))
            ->add('connaissancessectorielles', TextType::class, array('required' => false))
            ->add('competencesmetier', TextType::class, array('required' => false))
            ->add('interets', TextType::class, array('required' => false))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}