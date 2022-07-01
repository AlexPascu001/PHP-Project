<?php

namespace App\Controller;

use App\Form\FilterFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StationController extends AbstractController
{
    #[Route('/', name: 'app_station')]

    public function index(ManagerRegistry $manager): Response
    {
        $stations = $manager->getRepository('App\Entity\Station')->findAll();
        $locations = $manager->getRepository('App\Entity\Location')->findAll();
        $cities = [];
        foreach ($locations as $location) {
            if (!in_array($location->getCity(), $cities)) {
                $cities[] = $location->getCity();
            }
        }
        $form = $this->createForm(FilterFormType::class);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

        }
        return $this->render('station/index.html.twig', [
            'controller_name' => 'StationController',
            'stations' => $stations,
            'cities' => $cities,
            'form' => $form->createView()
        ]);
    }
}
