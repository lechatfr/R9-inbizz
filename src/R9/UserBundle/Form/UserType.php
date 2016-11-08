<?php

namespace R9\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use R9\InbizzBundle\Form\ImageType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           // ->setAction($this->generateUrl('r9_inbizz_profil_update'))
           // ->add('nom', TextType::class, array('required' => false))
           // ->add('prenom', TextType::class, array('required' => false))
           // ->add('agence', TextType::class, array('required' => false))
           // ->add('facebook', TextType::class, array('required' => false))
            // ->add('id', HiddenType::class)
            ->add('image',     ImageType::class, array('required' => false))
            ->add('agence', TextType::class, array('required' => false))
            ->add('facebook', TextType::class, array('required' => false))
            ->add('tel', TextType::class, array('required' => false))
            ->add('connaissancessectorielles', TextType::class, array('required' => false))
            ->add('competencesmetier', TextType::class, array('required' => false))
            ->add('interets', TextType::class, array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'R9\UserBundle\Entity\User'
        ));
    }
}
