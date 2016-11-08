<?php

namespace R9\InbizzBundle\Form;

use R9\InbizzBundle\Repository\MarquestatutRepository;
use R9\InbizzBundle\Repository\MarqueetatRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MarqueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image',     ImageType::class, array('required' => false))
            ->add('nom',     TextType::class)
            ->add('marquestatut',     EntityType::class, array(
                'class' => 'R9InbizzBundle:Marquestatut', 
                'query_builder' => function (MarquestatutRepository $repository) {
                    return $repository->getSelecterQueryBuilder();
                },
                'choice_label' => 'nom', 
                'placeholder' => false,
                'required' => false, 
                ))
            ->add('marqueetat',     EntityType::class, array(
                'class' => 'R9InbizzBundle:Marqueetat', 
                'query_builder' => function (MarqueetatRepository $repository) {
                    return $repository->getSelecterQueryBuilder();
                },
                'choice_label' => 'nom', 
                'placeholder' => false,
                'required' => false, 
                ))
            //->add('type',     TextType::class, array('required' => false))
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'PME' => 'PME',
                    'ETI' => 'ETI',
                    'Grande entreprise' => 'Grande entreprise',
                    'SBF 120' => 'SBF 120',
                    'Établissement public' => 'Établissement public',
                ),
                'placeholder' => 'Type de marque',
                'empty_data'  => null,
            ))
            //->add('secteurdactivite',     TextType::class, array('required' => false))
            ->add('secteurdactivite', ChoiceType::class, array(
                'choices'  => array(
                    'AGRICULTURE / bio doit aller dans ALIMENTATION' => 'AGRICULTURE / bio doit aller dans ALIMENTATION',
                    'ALIMENTATION' => 'ALIMENTATION',
                    'AMEUBLEMENT DÉCORATION' => 'AMEUBLEMENT DÉCORATION',
                    'APPAREILS MÉNAGERS' => 'APPAREILS MÉNAGERS',
                    'AUDIOVISUEL' => 'AUDIOVISUEL',
                    'AUTOMOBILE' => 'AUTOMOBILE',
                    'BATIMENT' => 'BATIMENT',
                    'BUREAUTIQUE' => 'BUREAUTIQUE',
                    'BUREAUTIQUE' => 'BUREAUTIQUE',
                    'CINÉMA' => 'CINÉMA',
                    'CULTURE & LOISIRS' => 'CULTURE & LOISIRS',
                    'DISTRIBUTION' => 'DISTRIBUTION',
                    'ÉDITION' => 'ÉDITION',
                    'ÉNERGIE' => 'ÉNERGIE',
                    'ENSEIGNEMENT FORMATION' => 'ENSEIGNEMENT FORMATION',
                    'ENTRETIEN' => 'ENTRETIEN',
                    'ÉTABLISSEMENTS FINANCIERS ASSURANCES' => 'ÉTABLISSEMENTS FINANCIERS ASSURANCES',
                    'HABILLEMENT ACCESS.TEXTILE' => 'HABILLEMENT ACCESS.TEXTILE',
                    'HORLOGERIE BIJOUTERIE' => 'HORLOGERIE BIJOUTERIE',
                    'HYGIÈNE BEAUTÉ' => 'HYGIÈNE BEAUTÉ',
                    'IMMOBILIER' => 'IMMOBILIER',
                    'INDUSTRIE' => 'INDUSTRIE',
                    'INDUSTRIE' => 'INDUSTRIE',
                    'INDUSTRIE' => 'INDUSTRIE',
                    'INFORMATION MÉDIA' => 'INFORMATION MÉDIA',
                    'INFORMATIQUE' => 'INFORMATIQUE',
                    'INFORMATIQUE ? BUREAUTIQUE ? AUDIOVISUEL ?' => 'INFORMATIQUE ? BUREAUTIQUE ? AUDIOVISUEL ?',
                    'JARDINAGE' => 'JARDINAGE',
                    'ORGANISMES HUMANITAIRES' => 'ORGANISMES HUMANITAIRES',
                    'PHOTO' => 'PHOTO',
                    'SANTÉ' => 'SANTÉ',
                    'SERVICES' => 'SERVICES',
                    'TÉLÉCOMMUNICATIONS' => 'TÉLÉCOMMUNICATIONS',
                    'TRANSPORT (autre que AUTOMOBILE)' => 'TRANSPORT (autre que AUTOMOBILE)',
                    'VOYAGE TOURISME' => 'VOYAGE TOURISME',
                ),
                'placeholder' => 'Secteur d\'activité',
                'empty_data'  => null,
            ))
            ->add('chiffredaffaire',     TextType::class, array('required' => false))
            ->add('nombredesalarie',     TextType::class, array('required' => false))
            ->add('adresse',     TextType::class, array('required' => false))
            ->add('adressecomplement',     TextType::class, array('required' => false))
            ->add('codepostal',     TextType::class, array('required' => false))
            ->add('ville',     TextType::class, array('required' => false))
            ->add('pays',     TextType::class, array('required' => false))
            ->add('web',     TextType::class, array('required' => false))
            ->add('twitter',     TextType::class, array('required' => false))
            ->add('facebook',     TextType::class, array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'R9\InbizzBundle\Entity\Marque'
        ));
    }
}
