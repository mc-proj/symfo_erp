<?php

namespace App\Form;

use App\Entity\SerpIntervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\SerpMachine;
use App\Entity\SerpIntervenant;
use App\Entity\SerpTypeIntervention;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Length;

class SerpInterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_type_intervention', EntityType::class, [
                'label' => "Type d'intervention",
                'class' => SerpTypeIntervention::class,
                'attr' => [
                    "style" => "background-color: white"
                ],
                'choice_label' => "nom",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un type d\'intervention'
                    ])
                ],
            ])
            ->add('id_machine', EntityType::class, [
                'label' => "Machine",
                'class' => SerpMachine::class,
                'attr' => [
                    "style" => "background-color: white"
                ],
                'choice_label' => "nom",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une machine'
                    ])
                ],
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
            ->add('observation', TextAreaType::class, [
                'attr' => [
                    'maxlength' => 255
                ],
                'constraints' => [
                    /*new NotBlank([
                        'message' => 'Veuillez entrer un nom'
                    ])*/
                    new Length([
                        'max' => 255,
                    ])
                ]
            ])


            //->add('date_debut')
            //->add('date_fin')
            //->add('observation')
            //->add('id_type_intervention')
            //->add('id_machine')
            //->add('id_intervenant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SerpIntervention::class,
        ]);
    }
}
