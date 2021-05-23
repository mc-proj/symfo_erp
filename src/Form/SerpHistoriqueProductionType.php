<?php

namespace App\Form;

use App\Entity\SerpHistoriqueProduction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\SerpOf;
use App\Entity\SerpIntervenant;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class SerpHistoriqueProductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_of', EntityType::class, [
                'label' => "Reference de l'ordre de fabrication",
                'class' => SerpOf::class,
                'attr' => [
                    "style" => "background-color: white"
                ],
                'choice_label' => "id",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un ordre de fabrication'
                    ])
                ],
            ])
            ->add('date_debut', DateTimeType::class, [
                'label' => 'Date début',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'input' => 'datetime',
                'constraints' => [new NotBlank(['message'=>'Veuillez choisir une date et heure de début']),
                    new NotNull(['message'=>'Veuillez choisir une date et heure de début'])],
            ])
            ->add('date_fin', DateTimeType::class, [
                'label' => 'Date fin',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'input' => 'datetime',
                'constraints' => [new NotBlank(['message'=>'Veuillez choisir une date et heure de fin']),
                    new NotNull(['message'=>'Veuillez choisir une date et heure de fin'])],
            ])
            ->add('id_intervenant', EntityType::class, [
                'label' => "Intervenant",
                'class' => SerpIntervenant::class,
                'attr' => [
                    "style" => "background-color: white"
                ],
                'choice_label' => function($intervenant) {
                    return $intervenant->getNom() . ' ' . $intervenant->getPrenom();
                },
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un intervenant'
                    ])
                ],
            ])
            ->add('quantite_debut', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une quantité de début'
                    ])
                ],
                'attr' => [
                    'min' => 0,
                    'step' => 1
                ]
            ])
            ->add('quantite_fin', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une quantité de fin'
                    ]),
                ],
                'attr' => [
                    'min' => 0,
                    'step' => 1
                ]
            ])    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SerpHistoriqueProduction::class,
        ]);
    }
}
