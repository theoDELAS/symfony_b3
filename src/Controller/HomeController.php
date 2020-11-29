<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/page/{page}", name="home_paginated")
     */
    public function index(GameRepository $gameRepository, PaginatorInterface $paginator, $page = 1): Response
    {
        $games = $gameRepository->getLatestPaginatedGames($paginator, $page);
        $games->setUsedRoute('home_paginated');
        return $this->render('home/index.html.twig', [
            'games' => $games,
        ]);
    }

    public function sideBar(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        
        return $this->render('sideBar.html.twig', [
            'categories' => $categories,
        ]);
    }
}
