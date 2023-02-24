<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Items;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        
        $categories = $manager->getRepository(Category::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 1; $i < 51; $i++) {
            $item = new Items;
            $item->setName("random-item-n". $i);
            $item->setStatus("Disponible");
            $item->setDescription("This is the description of random item number ". $i);
            $item->setIsVerified(false);
            $item->addCategory($faker->randomElement($categories));
            $item->setOwner($faker->randomElement($users));
                
            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies() 
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
