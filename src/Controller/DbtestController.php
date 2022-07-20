<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Page;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DbtestController extends AbstractController
{
    #[Route('/dbtest/fixtures', name: 'app_dbtest')]
    public function fixtures(ManagerRegistry $doctrine): Response
    {
        //récupération du repo des catégories
        $repository = $doctrine ->getRepository(Category::class);
        $categories = $repository->findAll();
        dump($categories);
        
        $repository = $doctrine ->getRepository(Tag::class);
        $tags = $repository->findAll();
        //inspection des tags d'un article
        dump($tags);

        foreach($articles as $article) {
            dump($article);
           

        }

        //récupération sdes tags de l'article
        $tags = $article->getTags();
        
        foreach ($tags as $tag) {
            //j'inspecte le tag
            dump($tag);
        }

        $repository = $doctrine ->getRepository(Page::class);
        $categories = $repository->findAll();
        dump($categories);
        exit();

        //finOneBy faudra mettre une valeur exacte, elle renvoie un objet ou une valeur nulle
        //findBy renverra un objet de type Array
    }
    #[Route('/db/test/orm', name: 'app_db_test_orm')]//par convention
    public function orm(ManagerRegistry $doctrine) {
       $repository = $doctrine->getRepository(Tag::class);
       $tags = $repository->findAll();
       dump($tags);

       // récupération d'un objet à partir de son id
       $id = 7;
       $tag = $repository->find($id);
       dump($tag);

       // récupération d'un objet à partir de son id
       $id = 1;
       $tag = $repository->find($id);
       dump($tag);

       // récupération de plusieurs objets à partir de son name
       $tags = $repository->findBy(['name' => 'carné']);
       dump($tags);

       // récupération d'un' objet à partir de son name
       $tag = $repository->findOneBy(['name' => 'carné']);
       dump($tag);

      //récupération de l'Entity Manager
       $manager = $doctrine ->getManager();
        
        if ($tag) 
        {
       // suppresion d'un objet
            $manager ->remove($tag);
            $manager -> flush();
        }
        




    //création d'un nouvel objet
        $tag = new Tag();
        $tag->setName('le dernier tag');
        
        dump($tag);
     //demande d'enregistrement de l'objet dans la BDD
        $manager->persist();
        $manager->flush();
        dump($tag);
        
    
    exit();
        
    }
#[Route('/db/test/repository', name:'app-db-test/repository')]
    public function repository(ArticleRepository $repository) {// je récupère une instance du repositiry
       $articles = $repository ->findAllSorted(); 
       dump($articles);
       
       exit();
    }

    #[Route('/db/test/repository', name: 'dbtest')]
    public function orm2(ArticleRepository $repository): Response
    {
$articles=$repository->findAllSorted();
dump($articles);
$articles=$repository->findByKeyword('plat');
dump($articles);
exit();
    }
}