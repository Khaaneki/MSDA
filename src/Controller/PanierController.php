<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Plat;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier', name: 'panier_')]
class PanierController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(SessionInterface $session, PlatRepository $platRepo)
    {
        $panier = $session->get('panier',[]);

        $data = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $plat = $platRepo->find($id);

            $data[] = [
                'plat' => $plat,
                'quantite' => $quantite
            ];
            $total += $plat->getPrix() * $quantite;
        }

        return $this->render('panier/index.html.twig', compact('data', 'total'));
    }

    #[Route('/add/{id}', name:'add')]
    public function add(SessionInterface $session, Plat $plat)
    {
        $id = $plat->getId();

        $panier = $session->get('panier',[]);
        
        if(empty($panier[$id])){
            $panier[$id] = 1;
        }else{
            $panier[$id]++;
        }
        
        $session->set('panier',$panier);

            return $this->redirectToRoute('panier_index');
    }

    #[Route('/remove/{id}', name:'remove')]
    public function remove(SessionInterface $session, Plat $plat)
    {
        $id = $plat->getId();

        $panier = $session->get('panier',[]);
        
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
            $panier[$id]--;
        }else{
            unset($panier[$id]);
        }
    }
        
        $session->set('panier',$panier);

            return $this->redirectToRoute('panier_index');
    }

    #[Route('/del/{id}', name:'del')]
    public function del(SessionInterface $session, Plat $plat)
    {
        $id = $plat->getId();

        $panier = $session->get('panier',[]);
        
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier',$panier);

            return $this->redirectToRoute('panier_index');
    }

    #[Route('/empty', name:'empty')]
    public function empty(SessionInterface $session,)
    {
        $session->remove('panier');

        return $this->redirectToRoute('panier_index');
    }
}