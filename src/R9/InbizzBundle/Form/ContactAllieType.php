<?php

namespace R9\InbizzBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactAllieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('civilite')
            ->remove('nom')
            ->remove('prenom')
            ->remove('email')
            ->remove('tel')
            ->remove('mobile')
            ->remove('fax')
            ->remove('statut')
            ->remove('fonction')
            ->remove('service')
            ->remove('pouvoir')
            ->remove('linkedin')
        ;
    }
    
    public function getParent()
    {
        return ContactType::class;
    }
}
