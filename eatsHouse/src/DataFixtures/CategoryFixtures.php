<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = ["Petit déjeuner", "Dîner", "Souper", "Apéro", "Brunch", "Goûter"];
        foreach ($categories as $key => $value)
        {
            $category = new Category();
            $category->setName($value);
            $manager->persist($category);
            $this->addReference('category' . $key, $category);
        }

        $manager->flush();
    }
}
