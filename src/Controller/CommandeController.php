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
    public function add(SessionInterface $session, PlatRepository $platRepo, EntityManagerInterface $em, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if($panier === []){
            $this->addFlash('message', 'Votre panier est vide');
            $this->redirectToRoute('app_district');
        }
        
        $form = $this->createForm(CommandeFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid())
        {

        $commande = new Commande();
        $commande->setUtilisateur($this->getUser());
        $total=0;
        foreach($panier as $item => $quantite){
            $detail = new Detail();

            $plat = $platRepo->find($item);

            $detail->setPlat($plat);
            $detail->setQuantite($quantite);
            $total += ($plat->getPrix() * $quantite);
            $detail->setquantite($quantite);

            $commande->addDetail($detail);
        }
        $date = new DateTime();
        $commande->setTotal($total);
        $commande->setDateCommande($date);
        $commande->setEtat(1);
        $commande->setAdresseFacturation($form->get('adresse_Facturation')->getData());
        $commande->setAdresseLivraison($form->get('adresse_Livraison')->getData());
        $commande->setPaiement($form->get('Paiement')->getData());
        $em->persist($commande);
        $em->flush();

        $session->remove('panier');
        return $this->render('district/index.html.twig');
    }
        return $this->render('commande/index.html.twig', [
            'CommandeFormType' => $form->createView(),
        ]);
    }

}