<?php

namespace App\Form;

use App\Entity\Station;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Controller\StationController;

class FilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', ChoiceType::class, [
                'choices' => [
                    'Select city' => '0',
                    'Bucuresti' => 'Bucuresti', 'Craiova' =>'Craiova', 'Cluj-Napoca' => 'Cluj-Napoca'
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Select charging type' => -1,
                    '0' => 0,
                    '1' => 1,
                    '2' => 2
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
