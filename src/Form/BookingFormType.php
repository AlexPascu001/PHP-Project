<?php

namespace App\Form;

use App\Repository\LocationRepository;
use App\Repository\StationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingFormType extends AbstractType
{
    private $manager;
    private $stationRepository;

    public function __construct(EntityManagerInterface $entityManager, StationRepository $stationRepository){
        $this->manager = $entityManager;
        $this->stationRepository = $stationRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('charge_start', DateTimeType::class,
                ['widget' => 'single_text',
                ]
            )
            ->add('charge_end', DateTimeType::class,
                ['widget' => 'single_text',
                ]
            )
            ->add('car_license_plate', TextType::class,

            )
            ->add('book', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
