<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PlatRepository;
use Symfony\Component\Routing\Annotation\Route;

class PlatController extends AbstractController
{
    private $platRepo;
    private $categorieRepo;

    public function __construct(PlatRepository $platRepo, CategorieRepository $categorieRepo)
    {
        $this->platRepo = $platRepo;
        $this->categorieRepo = $categorieRepo;
    }

    #[Route('/plat', name: 'app_plat')]
    public function index(): Response
    {
        $plat = $this->platRepo->findAll();
        $categories = $this->categorieRepo->findAll();

        return $this->render('plat/index.html.twig', [
            'controller_name' => 'PlatController',
            'plat' => $plat,
            'categories' => $categories
        ]);
    }

    #[Route('/plat/{categorie_id}', name: 'app_plat_cat')]
    public function show(int $categorie_id): Response
    {
        $categorie = $this->categorieRepo->find($categorie_id);

        return $this->render('plat/index.html.twig', [
            'controller_name' => 'PlatController',
            'plat' => $this->platRepo->findBy(['categorie' => $categorie])
        ]);
    }

    #[Route('/commander/{id}', name: 'commander_plat')]
    public function commanderPlat(int $id): Response
    {
        $plat = $this->platRepo->find($id);

        return $this->render('commande/commander.html.twig', [
            'controller_name' => 'PlatController',
            'plat' => $plat
        ]);
    }
}
