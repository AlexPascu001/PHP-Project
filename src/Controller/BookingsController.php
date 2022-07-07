<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Station;
use App\Form\BookingFormType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class BookingsController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function makeBooking(ManagerRegistry $managerRegistry, DateTime $charge_start, DateTime $charge_end, Station $station, array $bookings, Car $car=null): string
    {
        if (!$car) {
            return 'This car does not exist in the database!';
        }
        $booking_time = strtotime($charge_end->format('Y-m-d H:i:s')) - strtotime($charge_start->format('Y-m-d H:i:s'));
        if ($booking_time <= 0 or $booking_time > 7200) {
            return 'Bookings must take at most two hours!';
        }
        foreach ($bookings as $booking) {
            if ($booking->getStation()->getId() == $station->getId() and ((strtotime($booking->getChargeStart()->format('Y-m-d H:i:s')) - strtotime($charge_start->format('Y-m-d H:i:s')) >= 0
                        and strtotime($booking->getChargeStart()->format('Y-m-d H:i:s')) - strtotime($charge_end->format('Y-m-d H:i:s')) <= 0) or
                    (strtotime($booking->getChargeEnd()->format('Y-m-d H:i:s')) - strtotime($charge_end->format('Y-m-d H:i:s')) <= 0
                        and strtotime($booking->getChargeEnd()->format('Y-m-d H:i:s')) - strtotime($charge_start->format('Y-m-d H:i:s')) >= 0))) {
                return 'There is already a booking in that timeframe!';
            }
        }
        $car_bookings = $managerRegistry->getRepository('App\Entity\Booking')->findBy(['car' => $car]);
        foreach ($car_bookings as $car_booking) {
            if ((strtotime($car_booking->getChargeStart()->format('Y-m-d H:i:s')) - strtotime($charge_start->format('Y-m-d H:i:s')) >= 0
                    and strtotime($car_booking->getChargeStart()->format('Y-m-d H:i:s')) - strtotime($charge_end->format('Y-m-d H:i:s')) <= 0) or
                (strtotime($car_booking->getChargeEnd()->format('Y-m-d H:i:s')) - strtotime($charge_end->format('Y-m-d H:i:s')) <= 0
                    and strtotime($car_booking->getChargeEnd()->format('Y-m-d H:i:s')) - strtotime($charge_start->format('Y-m-d H:i:s')) >= 0)) {
                return 'This car already has a booking in that timeframe!';
            }
        }
        $booking = new Booking();
        $date_start = new DateTime($charge_start->format('Y-m-d H:i:s'));
        $booking->setChargeStart($date_start);
        $date_end = new DateTime($charge_end->format('Y-m-d H:i:s'));
        $booking->setChargeEnd($date_end);
        $booking->setStation($station);
        $booking->setCar($car);
        $managerRegistry->getManager()->persist($booking);
        $managerRegistry->getManager()->flush();
        return 'Successfully made a booking!';
    }


    /**
     * @throws \Exception
     */
    #[Route('/stations/{id}/book', name: 'app_bookings')]
    public function index(Request $request, ManagerRegistry $managerRegistry, Station $stationtemp): Response
    {
        $booking_form = $this->createForm(BookingFormType::class);
        $booking_form->handleRequest($request);

        $station_id = $stationtemp->getId();
        $bookings = $managerRegistry->getRepository('App\Entity\Booking')->findBy(['station' => $station_id]);

        if ($booking_form->isSubmitted() and $booking_form->isValid()) {
            $charge_start = $booking_form->getData()['charge_start'];
            $charge_end = $booking_form->getData()['charge_end'];
            $station = $managerRegistry->getRepository('App\Entity\Station')->findOneBy(['id' => $station_id]);
            $car_license_plate = $booking_form->getData()['car_license_plate'];
            $car = $managerRegistry->getRepository('App\Entity\Car')->findOneBy(['license_plate' => $car_license_plate]);
            $message = $this->makeBooking($managerRegistry, $charge_start, $charge_end, $station, $bookings, $car);
            $bookings = $managerRegistry->getRepository('App\Entity\Booking')->findBy(['station' => $station_id]);
            return $this->render('bookings/index.html.twig', [
                    'controller_name' => 'BookingsController',
                    'bookings' => $bookings,
                    'station_id' => $station_id,
                    'form' => $booking_form->createView(),
                    'message' => $message
                ]);

        }
        return $this->render('bookings/index.html.twig', [
            'controller_name' => 'BookingsController',
            'form' => $booking_form->createView(),
            'station_id' => $station_id,
            'message' => 'Make a booking!',
            'bookings' => $bookings
        ]);
    }
}
