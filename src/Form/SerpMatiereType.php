<?php

namespace App\Form;

use App\Entity\SerpMatiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints\NotBlank;

class SerpMatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom'
                    ])
                ]
            ])
            ->add('prix', MoneyType::class, [
                'divisor' => 100,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un prix'
                    ])
                ],
                /*'attr' => [
                    'min' => 0,
                    'step' => 0.01
                ]*/
            ])
            ->add('quantite_stock', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une quantité de stock'
                    ])
                ],
                'attr' => [
                    'min' => 0,
                    'step' => 1
                ]
            ])
            ->add('limite_basse_stock', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer une quantité de limite basse de stock'
                    ])
                ],
                'attr' => [
                    'min' => 0,
                    'step' => 1
                ]
            ])




            /*->add('nom')
            ->add('prix')
            ->add('quantite_stock')
            ->add('limite_basse_stock')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SerpMatiere::class,
        ]);
    }
}
