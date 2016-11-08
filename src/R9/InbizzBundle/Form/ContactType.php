<?php

namespace R9\InbizzBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typecontact',     HiddenType::class, array('required' => false))
            ->add('civilite', ChoiceType::class, array(
                'choices'  => array(
                    'M.' => 'M.',
                    'Mme' => 'Mme',
                ),
                'placeholder' => 'Civilité',
                'empty_data'  => null,
            ))
            ->add('nom',     TextType::class, array('required' => false))
            ->add('prenom',     TextType::class, array('required' => false))
            ->add('email',     TextType::class, array('required' => false))
            ->add('tel',     TextType::class, array('required' => false))
            ->add('mobile',     TextType::class, array('required' => false))
            ->add('fax',     TextType::class, array('required' => false))
            ->add('statut', ChoiceType::class, array(
                'choices'  => array(
                    'statut 1' => 'statut 1',
                    'statut 2' => 'statut 2',
                ),
                'placeholder' => 'Statut',
                'empty_data'  => null,
            ))
            ->add('fonction',     TextType::class, array('required' => false))
            ->add('service',     TextType::class, array('required' => false))
            ->add('pouvoir', ChoiceType::class, array(
                'choices'  => array(
                    'pouvoir 1' => 'pouvoir 1',
                    'pouvoir 2' => 'pouvoir 2',
                ),
                'placeholder' => 'Son pouvoir de décision',
                'empty_data'  => null,
            ))
            ->add('linkedin',     TextType::class, array('required' => false))
            ->add('relationcommerciale',     TextType::class, array('required' => false))
            ->add('projets', EntityType::class, array(
                'class'        => 'R9InbizzBundle:Contactprojet',
                'choice_label' => 'nom',
                'multiple'     => true,
                'expanded'     => true,
                'required'     => false,
              ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'R9\InbizzBundle\Entity\Contact'
        ));
    }
}
