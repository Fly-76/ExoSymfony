<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            '1$MVhQSlNXUmREUlE1VUw4dQ$/qEC1JwV+3FD06VOe0MnG5RUjOcix2IMjY4KwlA80mc'
        ));

        //$manager->flush();
    }
}
/*
pwd:admin
------------------ ---------------------------------------------------------------------------------------------------
Key                Value
------------------ ---------------------------------------------------------------------------------------------------
Encoder used       Symfony\Component\Security\Core\Encoder\MigratingPasswordEncoder
Encoded password   $argon2id$v=19$m=65536,t=4,p=1$MVhQSlNXUmREUlE1VUw4dQ$/qEC1JwV+3FD06VOe0MnG5RUjOcix2IMjY4KwlA80mc
------------------ ---------------------------------------------------------------------------------------------------
*/