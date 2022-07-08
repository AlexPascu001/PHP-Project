<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

class AppFixtureUsers extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
//        $cities = ["Craiova", "Bucharest", "Cluj", "Brasov", "Iasi"];
//        for ($i = 1; $i < 30; $i += 1) {
//            $user = new User();
//            $user->setName(generateRandomString());
//            $user->setCity($cities[random_int(0, sizeof($cities) - 1)]);
//            $user->setEmail($user->getName()."@gmail.com");
//            $manager->persist($user);
//        }
//        $manager->flush();
    }
}
