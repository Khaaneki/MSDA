<?php
namespace App\Service;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Plat;

class PanierService
{

    private $objet;
    private $quantite;
    
    public function __construct(plat $objet, int $quantite){
        $this->objet = $objet;
        $this->quantite=$quantite;
    }

public function ajoutPanier(plat $item,int $quantite)
{

}
}


?>