<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use App\entity\Page;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;


class TestFixtures extends Fixture
{
    public function __construct(ManagerRegistry $doctrine) {
        $this -> doctrine = $doctrine;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create('fr-FR');
        $this->loadCategories($manager, $faker);
        // $this->loadTags($manager, $faker);
        $this -> loadArticles($manager, $faker);
    }

    public function loadCategories(ObjectManager $manager,  FakerGenerator $faker):void
    {
        $categoryNames = [
            'cuisine francaise', 
            'cuisine italienne', 
            'cuisine ukrainienne', 
            'cuuisine grolandaise'
        ];

        foreach ($categoryNames as $catgoryName) {
            $category = new Category();
            $category->setName("cuisine thailandaise");       
            $manager->persist($category); 
        };

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName("cuisine {$faker -> countryCode()}");
            $manager->persist($category); //génère le code SQL qui permet de rendre l'enregistrement possible
        }
    }

    public function loadTags(ObjectManager $manager, FakerGenerator $faker):void {
        $faker = FakerFactory::create('fr_FR');
        $this->loadTags($manager, $faker);
        $tagNames = [
            'végétarien', 
            'équilibré',
            'aromatique'
        ];

        for ($i = 0; i < 10; $i++ ) {

        }

        $manager->flush();//exécute le code
    }
    public function loadArticles(ObjectManager $manager, FakerGenerator $faker):void {
        //on demande à doctrine(outil de com avec la BDD) de renovyer le repository(c'est un peu comme un getter)
        // pour récupérer une table (ici Category)
        $repository = $this ->doctrine->getRepository(Category::class);
        //on demande tout le contenu d'une table sous forme de tableau
        $categories = $repository->findAll();

        $repository = $this ->doctrine->getRepository(Tag::class);
        //on demande tout le contenu d'une table sous forme de tableau
        $categories = $repository->findAll();

        $articleDatas = [
            [
                'title' =>'Boeuf bourguignon',
                'body' =>'un plat bien francais',
                'published_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s',
                '2022-07-01 09:00:00'),
                //on peut réutiliser la liste des catégories, et y affecter cette itération
                'category' =>$categories[0],
                //ici, vu que plusieurs tags
                'tags '=> [$tags[2]]

            ],
            [
                'title' => 'Spaghetti carbonara',
                'body' =>'plus italien y a pas!!!',
                'published_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s',
                '2022-07-01 09:00:01'),
                'category' =>$categories[1],
                'tags' => [$tags[0], tags[2]]

            ],
            [
                'title' => 'Borsh',
                'body'  => 'l\'ukraine dans ce qu\'il y a de mieux',
                'published_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s',
                '2022-07-01 09:00:02')

            ]
            ];
            foreach ($articleDatas as $articleData) {
                $article = new Article();
                $article -> setTitle($articleData['title']);
                $article -> setBody($articleData['body']);
                $article -> setPublishedAt($articleData['published_at']);
                $article -> setCategory($articleData['category']);

                foreach ($articleData ('tags') as $tag) {
                    $article ->addTag($tag);
                }
                $manager ->persist($articleData);
                
            }
            for ($i = 0; $i < 200; $i++){
                $article = new Article();
                $article-> setTitle($faker->sentence());
                $article-> setBody($faker->paragraph(6));
            /*je géère une date aléatoir nulle 1 fois sur 10*/ 
                $date = $faker->optional($weight = 0, 9);
                $date = $faker->dateTimeBetween('-6 month', '+6 month');
                $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m')}-{$date->format('d')} {$date->format('H')}:{$date->format('i')}:{$date->format('s')}");
            // si la gestion de la date est trop compliquée, voici une alternative
            // $date = $faker->dateTimeThisYear();
            // $date = DateTimeImmutable::createFromInterface($date);
                $article->setPublishedAt($date);

                //sélection d'une catégorie depuis la list complète !!!!
                //la fonction renvoie un tableau. il faut donc utiliser le premier élément de ce tableau
                $category = $faker->randomElements($categories)[0];
                $article->setCategory($category);
               

                //génération d'un nombre alétoire compris entre 0 & 4 inclus
                $count = random_int(0, 4);
                $articleTags = $faker->randomElement($tags, $count);

              foreach($articleTags as $tags){

              }
        }

        $manager->persist($article);
       } 

       public function loadPages(ObjectManager $manager, FakerGenerator $faker):void {
        //on demande à doctrine(outil de com avec la BDD) de renovyer le repository(c'est un peu comme un getter)
        // pour récupérer une table (ici Category)
        $repository = $this ->doctrine->getRepository(Category::class);
        //on demande tout le contenu d'une table sous forme de tableau
        $categories = $repository->findAll();

        $repository = $this ->doctrine->getRepository(Tag::class);
        //on demande tout le contenu d'une table sous forme de tableau
        $categories = $repository->findAll();

        $pageDatas = [
            [
                'title' =>'la cuisine francaise',
                'body' =>'c\'est la cuisine de chez nous',
                'published_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s',
                '2022-07-01 09:00:00'),
                //on peut réutiliser la liste des catégories, et y affecter cette itération
                'category' =>$actegories[0],
                //ici, vu que plusieurs tags

            ],
            [
                'title' => 'cuisine italienne',
                'body' =>'cuisine de nos amis italiens',
                'published_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s',
                '2022-07-01 09:00:01'),

            ],
            [
                'title' => 'la cuisine',
                'body'  => 'la cuisine qui réchauffe venue du froid',
                'published_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s',
                '2022-07-01 09:00:02')

            ]
            ];
            foreach ($pageDatas as $pageData) {
                $page = new Article();
                $page-> setTitle($articleData['title']);
                $page -> setBody($articleData['body']);
                $page -> setCategory($articleData['category']);

                $manager ->persist($articleData);
                
            }
            for ($i = 0; $i < 10; $i++){
                $page = new Page();
                $page-> setTitle($faker->sentence());
                $page-> setBody($faker->paragraph(6));

                //sélection d'une catégorie depuis la list complète !!!!
                //la fonction renvoie un tableau. il faut donc utiliser le premier élément de ce tableau
                $category = $faker->randomElements($categories)[0];
                $page->setCategory($category);
               

                //génération d'un nombre alétoire compris entre 0 & 4 inclus
                $count = random_int(0, 4);
                $articleTags = $faker->randomElement($tags, $count);

              foreach($articleTags as $tags){

              }
        }

        $manager->persist($article);
       } 

    }