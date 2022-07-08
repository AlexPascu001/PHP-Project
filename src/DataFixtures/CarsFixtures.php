<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

function generateLicensePlate() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 3; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


class CarsFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $users = $manager->getRepository("App\Entity\User")->findAll();
        $counties = ["DJ", "B", "BV", "CJ"];
//        dd($users);
//        for ($i = 1; $i < 50; $i += 1) {
//            $car = new Car();
//            $car->setChargeType(random_int(0, 2));
//            $car->setLicensePlate($counties[random_int(0, sizeof($counties) - 1)].'-'.random_int(10, 99).'-'.generateLicensePlate());
//            $car->setUser($users[random_int(0, sizeof($users) - 1)]);
//            $manager->persist($car);
//        }
//        $manager->flush();
    }
}
