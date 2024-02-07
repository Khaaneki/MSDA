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
    public function add(SessionInterface $session, PlatRepository $platRepo, EntityManagerInterface $em): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if($panier === []){
            $this->addFlash('message', 'Votre panier est vide');
            $this->redirectToRoute('app_plat');
        }

        $total = 0;
        $commande = new Commande();
        $commande->setUtilisateur($this->getUser());

        foreach($panier as $item => $quantite){
            $Detail = new Detail();

            $plat = $platRepo->find($item);

            $Detail->setPlat($plat);
            $total += ($plat->getPrix() * $quantite);
            $Detail->setquantite($quantite);

            $commande->addDetail($Detail);
            $commande->setDateCommande($date_commande);
        }

        $em->persist($commande);
        $em->flush();

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController'
        ]);
    }

}