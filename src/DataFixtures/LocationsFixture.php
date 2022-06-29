<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LocationsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        for ($i = 1; $i < 10; $i += 1) {
            $location = new Location();
            $location->setName("Kaufland".$i);
            $location->setPrice(10 + $i);
            $location->setTotalPlaces(5 * $i);
            $location->setLatitude(44.2983902 + $i);
            $location->setLongitude(23.7931345 - $i);
            $manager->persist($location);
        }

        $manager->flush();
    }
}
