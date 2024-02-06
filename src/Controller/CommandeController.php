<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Repository\PlatRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CommandeFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commande', name: 'app_commande_')]
class CommandeController extends AbstractController
{   
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, PlatRepository $platRepo): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if($panier === []){
            $this->addFlash('message', 'Votre panier est vide');
            $this->redirectToRoute('app_plat');
        }

        $commande = new Commande();

        foreach($panier as $item => $quantite){
            $Detail = new Detail();

            $plat = $platRepo->find($item);
            dd($plat);
        }
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController'
        ]);
    }

}