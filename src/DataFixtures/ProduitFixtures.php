<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $produit1 = new Produit();
        $produit1
            ->setLibelle('Le Seigneur des Anneaux : La Communauté de l Anneau')
            ->setPrixunit(15.99)
            ->setQuantity(2) ;
        $manager->persist($produit1);

        $produit2 = new Produit();
        $produit2
            ->setLibelle('Le Seigneur des Anneaux : Les Deux Tours')
            ->setPrixunit(16.99)
            ->setQuantity(3) ;
        $manager->persist($produit2);

        $produit3 = new Produit();
        $produit3
            ->setLibelle('Le Seigneur des Anneaux : Le Retour du Roi')
            ->setPrixunit(17.99)
            ->setQuantity(1) ;
        $manager->persist($produit3);

        $produit4 = new Produit();
        $produit4
            ->setLibelle('Lost In Translation')
            ->setPrixunit(11.80)
            ->setQuantity(10) ;
        $manager->persist($produit4);

        $produit5 = new Produit();
        $produit5
            ->setLibelle('What We Do In The Shadows')
            ->setPrixunit(15.00)
            ->setQuantity(7) ;
        $manager->persist($produit5);

        $produit6 = new Produit();
        $produit6
            ->setLibelle('Knives Out')
            ->setPrixunit(12.30)
            ->setQuantity(6) ;
        $manager->persist($produit6);

        $produit7 = new Produit();
        $produit7
            ->setLibelle('Hereditary')
            ->setPrixunit(15.60)
            ->setQuantity(4) ;
        $manager->persist($produit7);

        $produit8 = new Produit();
        $produit8
            ->setLibelle('Midsommar')
            ->setPrixunit(21.00)
            ->setQuantity(2) ;
        $manager->persist($produit8);

        $produit9 = new Produit();
        $produit9
            ->setLibelle('Aftersun')
            ->setPrixunit(10.00)
            ->setQuantity(6) ;
        $manager->persist($produit9);

        $produit10 = new Produit();
        $produit10
            ->setLibelle('Eternal Sunshine of The Spotless Mind')
            ->setPrixunit(8.45)
            ->setQuantity(12) ;
        $manager->persist($produit10);

        $produit11 = new Produit();
        $produit11
            ->setLibelle('Scott Pilgrim')
            ->setPrixunit(18.80)
            ->setQuantity(5) ;
        $manager->persist($produit11);

        $produit12 = new Produit();
        $produit12
            ->setLibelle('Inglourious Basterds')
            ->setPrixunit(25.15)
            ->setQuantity(16) ;
        $manager->persist($produit12);

        $produit13 = new Produit();
        $produit13
            ->setLibelle('Licorice Pizza')
            ->setPrixunit(5.50)
            ->setQuantity(9) ;
        $manager->persist($produit13);

        $produit14 = new Produit();
        $produit14
            ->setLibelle('Phantom Thread')
            ->setPrixunit(10.90)
            ->setQuantity(0) ;
        $manager->persist($produit14);

        $produit15 = new Produit();
        $produit15
            ->setLibelle('Her')
            ->setPrixunit(1.00)
            ->setQuantity(4) ;
        $manager->persist($produit15);

        $produit16 = new Produit();
        $produit16
            ->setLibelle('Twilight Chapitre 1 : Fascination')
            ->setPrixunit(15.30)
            ->setQuantity(8) ;
        $manager->persist($produit16);

        $produit17 = new Produit();
        $produit17
            ->setLibelle('Twilight Chapitre 2 : Tentation')
            ->setPrixunit(16.30)
            ->setQuantity(9) ;
        $manager->persist($produit17);

        $produit18 = new Produit();
        $produit18
            ->setLibelle('Twilight Chapitre 3 : Hésitation')
            ->setPrixunit(17.30)
            ->setQuantity(10) ;
        $manager->persist($produit18);

        $produit19 = new Produit();
        $produit19
            ->setLibelle('Twilight Chapitre 4 : Révélation (1ère partie)')
            ->setPrixunit(18.30)
            ->setQuantity(11) ;
        $manager->persist($produit19);

        $produit20 = new Produit();
        $produit20
            ->setLibelle('Twilight Chapitre 5 : Révélation (2ème partie)')
            ->setPrixunit(19.30)
            ->setQuantity(12) ;
        $manager->persist($produit20);

        $manager->flush();
    }
}
