<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class LocationsFixture extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $cities = ['Craiova', 'Cluj-Napoca', 'Bucharest', 'Iasi', 'Brasov'];
        $loc1 = ['Kaufland', 'Auchan', 'City Center'];
        $loc2 = ['Parking', 'Charging Stations'];

        for ($i = 1; $i < 10; $i += 1) {
            $location = new Location();
            $location->setName($loc1[random_int(0, sizeof($loc1) - 1)].' '.$loc2[random_int(0, sizeof($loc2) - 1)]);
            $location->setCity($cities[random_int(0, sizeof($cities) - 1)]);
            $location->setPrice(10 + $i);
            $location->setTotalPlaces(5 * $i);
            $location->setLatitude(44.2983902 + $i);
            $location->setLongitude(23.7931345 - $i);
            $manager->persist($location);
        }

        $manager->flush();
    }
}
