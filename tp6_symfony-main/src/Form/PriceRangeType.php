<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class PriceRangeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minPrice', NumberType::class, [
                'label' => 'Prix minimum',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prix minimum',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un prix minimum']),
                    new PositiveOrZero(['message' => 'Le prix minimum doit être positif ou zéro']),
                ],
            ])
            ->add('maxPrice', NumberType::class, [
                'label' => 'Prix maximum',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Prix maximum',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un prix maximum']),
                    new PositiveOrZero(['message' => 'Le prix maximum doit être positif ou zéro']),
                ],
            ])
            ->add('search', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
} 