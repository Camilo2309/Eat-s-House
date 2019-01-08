<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use App\Entity\Location;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
       $faker = Faker\Factory::create('fr_FR');

        for ($i = 1; $i < 25; $i++) {

            $location = new Location();
            $location->setAddress($faker->address());
            $location->setLatitude($faker->latitude($min = -56, $max = 90));
            $location->setLongitude($faker->longitude($min = -180, $max = 180));
            $location->setUser($this->getReference('user' . $i));
            $manager->persist($location);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
