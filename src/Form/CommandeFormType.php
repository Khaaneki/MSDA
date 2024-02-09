<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class CommandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse_Livraison' ,TextType::class ,[
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Adresse de livraison'
                ])
            ->add('adresse_Facturation',TextType::class ,[
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Adresse de facturation'
                ])
                ->add('Paiement', ChoiceType::class, [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez sélectionner le mode de paiement',
                        ]),
                        new Choice([
                            'choices' => ['VISA', 'PAYPAL', 'LA CARTE DE MAMAN'],
                            'message' => 'Veuillez sélectionner un mode de paiement valide',
                        ]),
                    ],
                    'label' => 'Méthode de paiement',
                    'choices' => [
                        'Sélectionnez le mode de paiement' => null,
                        'VISA' => 'VISA',
                        'PAYPAL' => 'PAYPAL',
                        'LA CARTE DE MAMAN' => 'LA CARTE DE MAMAN'
                    ],
                ])
            ->add('CGU_validation',  CheckboxType::class,[
                                    'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Coche moi cette case !!!!!.',
                    ]),
                ],
                'label' => 'J\'accepte les conditions générales d\'utilisation ' , 'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}