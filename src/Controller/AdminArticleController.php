<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\WriterRepository;
use App\Entity\Writer;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/article')]
class AdminArticleController extends AbstractController
{
   private WriterRepository $writerReposirory;
    public function __construct(WriterRepository $writerRepository) {

    }
    
    #[Route('/', name: 'app_admin_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = [];
        $user = $this-getUser();
        if($this->isGranted('ROLE_EDITOR')) {
            $articles = articleRpository->findAll();
        }elseif ($this->isGranted('ROLE_WRITER')) {
            //$user
        }
        
        return $this->render('admin_article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository): Response
    {
        //si l'utilisateur n'est ni éditeur ni auteur, il ne pourra pas créer 
        if (!$this->isGranted('ROLE_EDITOR') && !$this->isGranted('ROLE_WRITER')) 
        {
            throw new AccessDeniedException();
        }
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->add($article, true);

            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        $this->filterUser();
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

          
    }

    #[Route('/{id}/edit', name: 'app_admin_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $this->filterUser();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->add($article, true);

            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    

    #[Route('/{id}', name: 'app_admin_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
       
    {
        $this->filterUser();
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
    }

    private function filterUser(Article $article) {
          //ce bloc de code permet d'attribuer un accès à la page en fonction du role
          if (!$this->isGranted('ROLE_EDITOR') && !$this->isGranted('ROLE_WRITER')) {//si l'utilisateur n'a pas le role d'écrivain
            $user =$this -> getUser();
            $writer = $this->writerRepository();
            $articles = $writer->getArticles();
            if (!$articles->contains($article)) {
                throw new AccessDeniedException();
            }
        }
        
    }

}