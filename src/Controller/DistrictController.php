<?php

namespace App\Controller;

use App\Repository\Categorie;
use App\Repository\Plat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistrictController extends AbstractController
{

private $categorie;
private $plat;

public function __construct(categorieRepository $categorieRepo, DiscRepository $PlatRepo)
{
    $this->categorieRepo = $categorieRepo;
    $this->platRepo = $platRepo;

}

#[Route('/district', name: 'app_district')]
public function index(): Response
{

    $categorie = $this->categorieRepo->findAll();

    return $this->render('district/index.html.twig', [
        'controller_name' => 'DistrictController',
        'Categorie' => $categorie
    ]);
}

}