<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistrictController extends AbstractController
{
    private $categorie;
    private $plat;

    public function __construct(CategorieRepository $categorieRepo, PlatRepository $platRepo)
    {
        $this->categorie = $categorieRepo;
        $this->plat = $platRepo;
    }

    #[Route('/district', name: 'app_district')]
    public function index(): Response
    {
        $categories = $this->categorie->findAll();
    
        return $this->render('district/index.html.twig', [
            'controller_name' => 'DistrictController',
            'categories' => $categories
        ]);
    }
    
    #[Route('/categorie', name: 'app_categorie')]
    public function nouvelleVue(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'DistrictController',
        ]);
    }
}