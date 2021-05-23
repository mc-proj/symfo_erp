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
//ce formulaire est uniquement destine à la creation de nouvelles entites

class SerpMatiereProduitType extends AbstractType
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
            ->add('id_matiere', EntityType::class, [
                'label' => "matiere à lier",
                'class' => SerpMatiere::class,
                'attr' => [
                    "style" => "background-color: white"
                ],
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
