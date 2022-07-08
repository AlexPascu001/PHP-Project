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
        $coordinates = [['Craiova', 'Kaufland 1 Mai', 44.300397, 23.795630], ['Craiova', 'City Center', 44.320074, 23.797626], ['Craiova', 'Electroputere Mall', 44.312750, 23.831829],
            ['Bucharest', 'City Center', 44.434349, 26.101246], ['Bucharest', 'Kaufland Basarab', 44.448204, 26.067836], ['Bucharest', 'Baneasa Mall', 44.505589, 26.089251],
            ['Bucharest', 'Mega Mall', 44.442972, 26.151889], ['Bucharest', 'Auchan Vitan', 44.407510, 26.139369],
            ['Cluj-Napoca', 'Kaufland Intre Lacuri', 46.780757, 23.638587], ['Cluj-Napoca', 'Iulius Mall', 46.771568, 23.625464], ['Cluj-Napoca', 'Auchan Iris', 46.799081, 23.611130],
            ['Brasov', 'Kaufland Bartolomeu', 45.658544, 25.590193], ['Brasov', 'Auchan Coresi', 45.673121, 25.617598], ['Brasov', 'City Center', 45.652297, 25.613564],
            ['Iasi', 'City Center', 47.164345, 27.584329], ['Iasi', 'Palas Mall', 47.158129, 27.588798]
        ];
        for ($i = 0; $i < sizeof($coordinates); $i += 1) {
            $location = new Location();
            $location->setCity($coordinates[$i][0]);
            $location->setName($coordinates[$i][1]);
            $location->setPrice(10 + $i);
            $location->setTotalPlaces(5 * $i);
            $location->setLatitude($coordinates[$i][2]);
            $location->setLongitude($coordinates[$i][3]);
            $manager->persist($location);
        }

        $manager->flush();
    }
}
