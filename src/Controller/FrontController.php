<?php

namespace App\Controller;

use App_Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_front_index')]
    public function index(): Response
    {
        $articles = $repository->findNlast(5);

        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
}