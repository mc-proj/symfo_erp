<?php

namespace App\Form;

use App\Entity\SerpMatiereProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\SerpProduit;
use App\Entity\SerpMatiere;
//ce formulaire est uniquement destine à l'edition de nouvelles entites

class SerpMatiereProduitEditionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantite_matiere', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une quantité'
                    ])
                ],
                "attr" => [
                    "min" => 0
                ]
            ])
            ->add('id_produit', EntityType::class, [
                'label' => "produit",
                'class' => SerpProduit::class,
                'choice_label' => 'nom'
            ])
            ->add('id_matiere', EntityType::class, [
                'label' => "matiere à lier",
                'class' => SerpMatiere::class,
                'choice_label' => 'nom'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SerpMatiereProduit::class,
        ]);
    }
}
