<?php

namespace App\Fixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $admin = $this->createAdmin();
        $manager->persist($admin);
        $manager->flush();

        // example user
        for($i=1; $i<6; $i++)
        {
            $user = new User();
            $user->setEmail('example'.$i.'@example.com');
            $user->setUsername('Example '.$i);
            $password = $this->hasher->hashPassword($user, 'example123');
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }
    }

    private function createAdmin(): User
    {
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setUsername('Admin');
        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);

        return $user;
    }
}
