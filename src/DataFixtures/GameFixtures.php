<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Game;
use App\Entity\Category;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        $categories = ['Guerre', 'Action', 'Aventure'];

        $categoriesTab = [];

        for ($i=0; $i < sizeof($categories); $i++) { 
            $category = new Category;

            $category->setName($categories[$i]);
            $category->setSlug($slugify->slugify($categories[$i]));
            $categoriesTab[] = $category;

            $manager->persist($category);
        }

        for ($i=0; $i < 60; $i++) { 
            $game = new Game();

            $name = $faker->text(25);
    
            $game->setName($name);
            $game->setDateAdd($faker->dateTimeBetween('-2 years', 'now'));
            $game->setDescription($faker->text(300));
            $game->setUser($this->getReference('user'.random_int(0, UserFixtures::USER_COUNT - 1)));
            $game->setCategory($categoriesTab[array_rand($categoriesTab)]);
            $game->setSlug($slugify->slugify($name));

            $manager->persist($game);
        }

        $manager->flush();
    }

    public function getDependencies() {
        return [
            UserFixtures::class
        ];
    }
}
