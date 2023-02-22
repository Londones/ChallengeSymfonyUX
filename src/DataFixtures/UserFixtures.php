<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        
        $categories = $manager->getRepository(Category::class)->findAll();

        for ($i = 1; $i < 41; $i++) {
            $user = new User;
            $user->setName("user-". $i);
            $user->setEmail("user-". $i . "@gmail.com");
            $user->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $user, "password"
                )
            );
            $user->setIsEmailVerified(true);
            $userCategories = $faker->randomElements($categories, 2);
            $user->addCategory($userCategories[0]);
            $user->addCategory($userCategories[1]);
                
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies() 
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
