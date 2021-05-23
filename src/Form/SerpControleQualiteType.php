<?php

namespace App\Form;

use App\Entity\SerpControleQualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\SerpOf;
use App\Entity\SerpIntervenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;

class SerpControleQualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite_controlee', IntegerType::class, [
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
            ->add('id_intervenant', EntityType::class, [
                'label' => "Nom de l'intervenant",
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
            ->add('of_id', EntityType::class, [
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SerpControleQualite::class,
        ]);
    }
}
