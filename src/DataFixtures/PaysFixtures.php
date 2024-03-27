<?php

namespace App\DataFixtures;

use App\Entity\Pays;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaysFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pays1 = new Pays();
        $pays1
            ->setName('France')
            ->setShortname('FR') ;
        $manager->persist($pays1);

        $pays2 = new Pays();
        $pays2
            ->setName('Allemagne')
            ->setShortname('DE') ;
        $manager->persist($pays2);

        $pays3 = new Pays();
        $pays3
            ->setName('Belgique')
            ->setShortname('BE') ;
        $manager->persist($pays3);

        $pays4 = new Pays();
        $pays4
            ->setName('Danemark')
            ->setShortname('DK') ;
        $manager->persist($pays4);

        $pays5 = new Pays();
        $pays5
            ->setName('Espagne')
            ->setShortname('ES') ;
        $manager->persist($pays5);

        $pays6 = new Pays();
        $pays6
            ->setName('Finlande')
            ->setShortname('FI') ;
        $manager->persist($pays6);

        $pays7 = new Pays();
        $pays7
            ->setName('Grèce')
            ->setShortname('GR') ;
        $manager->persist($pays7);

        $pays8 = new Pays();
        $pays8
            ->setName('Irlande')
            ->setShortname('IE') ;
        $manager->persist($pays8);

        $pays9 = new Pays();
        $pays9
            ->setName('Italie')
            ->setShortname('IT') ;
        $manager->persist($pays9);

        $pays10 = new Pays();
        $pays10
            ->setName('Pologne')
            ->setShortname('PL') ;
        $manager->persist($pays10);

        $pays11 = new Pays();
        $pays11
            ->setName('Portugal')
            ->setShortname('PT') ;
        $manager->persist($pays11);

        $pays12 = new Pays();
        $pays12
            ->setName('Suède')
            ->setShortname('SE') ;
        $manager->persist($pays12);

        $manager->flush();
    }
}
