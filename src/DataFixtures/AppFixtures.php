<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Category;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        // Users
        $users =  [];
        for ($i=0; $i < 50; $i++) { 
            $user = new User();
            $user->setUsername($faker->name);
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setEmail($faker->email);
            $user->setPassword($faker->password());
            $user->setCreatedAt(new \DateTime());
            $manager->persist($user);
            $users[] = $user;
        }
        // Category
        $categories = [];
        for ($i=0; $i < 15; $i++) { 
            # code...
            $category = new Category();
            $category->setTitle($faker->text(50));
            $category->setDescription($faker->text(1000));
            // $category->setImage($faker->imageUrl());
            $category->setImage("https://picsum.photos/1200/350?random=".mt_rand(1, 55000));
            $manager->persist($category);
            $categories[] = $category;
        }
        // Article
        $articles = [];
        for ($i=0; $i < 100; $i++) { 
            $article = new Article();
            $article->setTitle($faker->text(50));
            $article->setContent($faker->text(1000));
            // $article->setImage($faker->imageUrl());
            $article->setImage("https://picsum.photos/1200/350?random=".mt_rand(1, 55000));
            $article->setCreatedAt(new \DateTime());
            $article->addCategory($categories[$faker->numberBetween(0, 14)]);
            $article->setAuthor($users[$faker->numberBetween(0, 49)]);
            $manager->persist($article);
            $articles[] = $article;
        }

        $manager->flush();
    }
}
