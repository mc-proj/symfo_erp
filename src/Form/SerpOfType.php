<?php

namespace App\Form;

use App\Entity\SerpOf;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\SerpClient;
use App\Entity\SerpMachine;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;


class SerpOfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_client', EntityType::class, [
                'label' => "Nom du client",
                'class' => SerpClient::class,
                'attr' => [
                    "style" => "background-color: white"
                ],
                'choice_label' => "nom",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un client'
                    ])
                ],
            ])
            ->add('quantite_commandee', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une quantité'
                    ])
                ],
                'attr' => [
                    'min' => 0,
                    'step' => 1
                ]
            ])
            ->add('date_commande', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de la commande',
                'empty_data' => null,
            ])
            ->add('machine_id', EntityType::class, [
                'label' => "Machine associée",
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SerpOf::class,
        ]);
    }
}
