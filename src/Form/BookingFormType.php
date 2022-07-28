<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\CarRepository;
use App\Repository\LocationRepository;
use App\Repository\StationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    private $carRepository;

    public function __construct(ManagerRegistry $managerRegistry, CarRepository $carRepository){
        $this->manager = $managerRegistry;
        $this->carRepository = $carRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('charge_start', DateTimeType::class,
                ['widget' => 'single_text',
                ]
            )
            ->add('charge_end', DateTimeType::class,
                ['widget' => 'single_text',
                ]
            )
            ->add('car_license_plate', ChoiceType::class, [
                    'choices' => array_merge(['Select car' => 'Select car'], $this->carRepository->getCars($user)),
                    'choice_label' => function ($value) {
                        return $value;
                    }
                ]

            )
            ->add('book', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => null
        ]);
        $resolver->setAllowedTypes('user', User::class);
    }
}
