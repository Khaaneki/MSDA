<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Plat;
use App\Entity\Commande;
use DateTime;
use App\Entity\Utilisateur;

class DistrictMSDA extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
        //Categorie

        $categorie1 = new Categorie();

        $categorie1->setlibelle("Pizza");
        $categorie1->setimage("pizza_cat.jpg");
        $categorie1->setIsActive('1');
        $manager->persist($categorie1);

        $categorie2 = new Categorie();

        $categorie2->setlibelle("Burger");
        $categorie2->setimage("burger_cat.jpg");
        $categorie2->setIsActive('1');
        $manager->persist($categorie2);

        $categorie3 = new Categorie();

        $categorie3->setlibelle("Asian Food");
        $categorie3->setimage("asian_food_cat.jpg");
        $categorie3->setIsActive('1');

        $manager->persist($categorie3);
        $manager->flush();

        //Plat

        $plat1 = new Plat();

        $plat1->setCategorie($categorie3);
        $plat1->setLibelle('Maki');
        $plat1->setDescription('saumon, algue, riz');
        $plat1->setPrix(7.50);
        $plat1->setImage('sushiiiiii.jpeg');
        $plat1->setIsActive(1);
        $manager->persist($plat1);

        $plat2 = new Plat();

        $plat2->setcategorie($categorie3);
        $plat2->setlibelle('Nems');
        $plat2->setdescription('poulet, vermicelles de riz, sauce nuoc mam');
        $plat2->setprix(4.50);
        $plat2->setimage('nems poulet.jpg');
        $plat2->setIsActive(1);
        $manager->persist($plat2);

        $plat3 = new Plat();

        $plat3->setcategorie($categorie2);
        $plat3->setlibelle('Royal');
        $plat3->setdescription('steak haché, salade, bacon');
        $plat3->setprix(7.50);
        $plat3->setimage('Food-Name-6340.jpg');
        $plat3->setIsActive(1);
        $manager->persist($plat3);

        $plat4 = new Plat();

        $plat4->setcategorie($categorie2);
        $plat4->setlibelle('Slider');
        $plat4->setdescription('steak haché, salade, tomate, fromage');
        $plat4->setprix(9.50);
        $plat4->setimage('hamburger.jpg');
        $plat4->setIsActive(1);
        $manager->persist($plat4);

        $plat5 = new Plat();

        $plat5->setcategorie($categorie1);
        $plat5->setlibelle('Burger');
        $plat5->setdescription('boeuf haché, tomate, oignon, cheddar, sauce tomate 	');
        $plat5->setprix(13.50);
        $plat5->setimage('pizza_burger.jpeg');
        $plat5->setIsActive(1);
        $manager->persist($plat5);
        
        $plat6 = new Plat();
        
        $plat6->setcategorie($categorie1);
        $plat6->setlibelle('Norvegienne');
        $plat6->setdescription('crème fraiche, saumon, mozzarella');
        $plat6->setprix(12.50);
        $plat6->setimage('pizza-salmon.png');
        $plat6->setIsActive(1);
        $manager->persist($plat6);

        //Commande

        $commande1 = new Commande();
        $date1 = new DateTime();

        $commande1->setDateCommande($date1);
        $commande1->setTotal(24.50);
        $commande1->setEtat(1);
        $utilisateur1 = $manager->getRepository(Utilisateur::class)->find(1);
        $commande1->setUtilisateur($utilisateur1);
        $manager->persist($commande1);

        $commande2 = new Commande();
        $date2 = new DateTime();

        $commande2->setDateCommande($date2);
        $commande2->setTotal(24.50);
        $commande2->setEtat(1);
        $utilisateur2 = $manager->getRepository(Utilisateur::class)->find(2);
        $commande2->setUtilisateur($utilisateur2);
        $manager->persist($commande2);
        
        $manager->flush();
    }
}