<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class ZBookingsFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $cars = $manager->getRepository("App\Entity\Car")->findAll();
        $stations = $manager->getRepository("App\Entity\Station")->findAll();
//        for ($i = 1; $i < 100; $i += 1) {
//            $booking = new Booking();
//            $booking->setCar($cars[random_int(0, sizeof($cars) - 1)]);
//            $booking->setStation($stations[random_int(0, sizeof($stations) - 1)]);
//            $booking->setChargeStart(strtotime(date("d-m-Y ",mktime(0, 0, 0, 1, 1, 2022))));
//            $booking->setChargeEnd(strtotime(date("d-m-Y ",mktime(12, 0, 0, 1, 1, 2022))));
//            $manager->persist($booking);
//        }
        $manager->flush();
    }
}
