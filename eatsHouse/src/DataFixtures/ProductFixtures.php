<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Product;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Nous gérons les annonces
        for ($i = 1; $i <= 25; $i++) {

            $product = new Product();

            $title = $faker->sentence();
            $description = '<p>' .join('</p><p>', $faker->paragraphs(3)) . '</p>';

//            $user = $users[mt_rand(0, count($users) -1)];
            $product->setTitle($title)
                ->setDescription($description)
                ->setPrice(mt_rand(40, 400))
                ->setUser($this->getReference('user' . $i))
                ->setCategory($this->getReference('category' . rand(0, 5)));


            for($j = 1; $j <= mt_rand(2, 3); $j++) {

                $image = new Image();

                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setProduct($product);

                $manager->persist($image);
            }
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LocationFixtures::class,
            CategoryFixtures::class,
        );
    }
}
