<?php

namespace App\Form;

use App\Entity\Station;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Controller\LocationsController;

class FilterFormType extends AbstractType
{

    private $manager;
    private $locationsRepo;

    public function __construct(EntityManagerInterface $entityManager, LocationRepository $locationRepository){
        $this->manager = $entityManager;
        $this->locationsRepo = $locationRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', ChoiceType::class, [
                'choices' => array_merge(['Select city' => 'Select city'], $this->locationsRepo->getCities()),
                'choice_label' => function ($value) {
                    return $value;
                }
            ])
            ->add('filter', SubmitType::class, [
                'attr' => ['class' => 'filter']
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
