<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Station;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class StationsFixture extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $locations = $manager->getRepository("App\Entity\Location")->findAll();

        for ($i = 1; $i < 100; $i += 1) {
            $station = new Station();
            $station->setType(random_int(0, 2));
            $station->setPower(random_int(50, 100));
            $station->setLocation($locations[random_int(0, sizeof($locations) - 1)]);
            $manager->persist($station);
        }
        $manager->flush();
    }
}
