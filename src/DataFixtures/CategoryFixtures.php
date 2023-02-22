<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Yaml\Yaml;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = Yaml::parseFile(__DIR__ . "/categories.yaml");

        foreach ($categories as $categoryData) {
            $category = new Category();
            $category->setName($categoryData["name"]);
            $category->setDescription($categoryData["description"]);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
