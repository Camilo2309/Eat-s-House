<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Gérer les Users

        $users = [];
        $genres = ['male', 'female'];

        for ($i = 1; $i <= 25; $i++) {

            $user = new User();

            $roles = ['ROLE_ADMIN', 'ROLE_HOST'];
            //element au hasard de ce tableau
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';

            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            // si genre est = a  male alors écrit 'men/' :SINON: écrit 'women/'
            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setLogin($faker->firstName($genre))
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setPhone($faker->phoneNumber)
                ->setRoles($faker->randomElements($roles))
                ->setPassword($hash)
                ->setPicture($picture);

            $manager->persist($user);
            $this->addReference('user' . $i, $user);

            $users[] = $user;
        }

        $manager->flush();
    }
}