<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SerpCategoriesRepository;
use App\Repository\SerpClientRepository;

/**
* @Route("/")
*/

class MainController extends AbstractController
{
    private $serp_categories;

    public function __construct(
            SerpClientRepository $serp_client_repository,
            SerpCategoriesRepository $serp_categories
        ) {
        $this->serp_client_repository = $serp_client_repository;
        $this->serp_categories = $serp_categories;
    }

    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        $categories = $this->serp_categories->findAllSortedByNomAsc();

        return $this->render('main/index.html.twig', [
            'categories' => $categories
        ]);
    }
}
