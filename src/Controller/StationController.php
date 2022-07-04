<?php

namespace App\Controller;

use App\Form\FilterFormType;
use App\Repository\LocationRepository;
use App\Repository\StationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StationController extends AbstractController
{

    private $manager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->manager = $entityManager;
    }

    #[Route('/', name: 'app_station')]

    public function index(Request $request, LocationRepository $locationRepository, StationRepository $stationRepository): Response
    {
        $allStations = $this->manager->getRepository('App\Entity\Station')->findAll();
        $form = $this->createForm(FilterFormType::class);
        $form->handleRequest($request);

        $cityFound = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $cityFound = $form->getData();
        }
//        dd($cityFound);
//        if (in_array('Select city', $cityFound)) {
//            if ($cityFound['type'] == -1)
//                $stations = $stationRepository->findAll();
//            else
//                $stations = $stationRepository->getSelectedStationsType($cityFound['type']);
//        }
//        else {
//            if ($cityFound['type'] == -1)
//                $stations = $stationRepository->getSelectedStationsCity($cityFound['city']);
//            else
//                $stations = $stationRepository->getSelectedStations($cityFound['type'], $cityFound['city']);
//        }
        $stations = $stationRepository->getSelectedStations($cityFound['type'], $cityFound['city']);
        return $this->render('station/index.html.twig', [
            'controller_name' => 'StationController',
            'stations' => $stations,
            'form' => $form->createView()
        ]);
    }
}
