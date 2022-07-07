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

    #[Route('/stations', name: 'app_station')]

    public function index(Request $request, StationRepository $stationRepository): Response
    {
        $form = $this->createForm(FilterFormType::class);
        $form->handleRequest($request);

        $data = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        }
        $stations = $stationRepository->getSelectedStations($data['type'] ?? -1, $data['city'] ?? 'Select city');
        return $this->render('station/index.html.twig', [
            'controller_name' => 'StationController',
            'stations' => $stations,
            'form' => $form->createView(),
            'url' => '/book'
        ]);
    }



}
