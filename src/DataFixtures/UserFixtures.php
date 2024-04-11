<?php

namespace App\DataFixtures;

use App\Entity\Pays;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    private ?UserPasswordHasherInterface $passwordHasher = null;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user1 = new User() ;
        $user1
            ->setLogin('sadmin')
            ->setAdmin(true)
            ->setRoles(['ROLE_SADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($user1, 'nimdas');
        $user1->setPassword($hashedPassword);
        $manager->persist($user1);

        $user2 = new User() ;
        $user2
            ->setLogin('gilles')
            ->setAdmin(true)
            ->setName('Gilles')
            ->setLastname('Subrenat')
            ->setRoles(['ROLE_ADMIN'])
            ->setPays($manager->getRepository( Pays::class)->findOneBy(['name' => 'France']));
        $hashedPassword = $this->passwordHasher->hashPassword($user1, 'sellig');
        $user2->setPassword($hashedPassword);
        $manager->persist($user2);

        $user3 = new User() ;
        $user3
            ->setLogin('rita')
            ->setAdmin(false)
            ->setName('Rita')
            ->setLastname('Zrour')
            ->setRoles(['ROLE_CLIENT'])
            ->setPays($manager->getRepository( Pays::class)->findOneBy(['name' => 'France']));
        $hashedPassword = $this->passwordHasher->hashPassword($user1, 'atir');
        $user3->setPassword($hashedPassword);
        $manager->persist($user3);

        $user4 = new User() ;
        $user4
            ->setLogin('boumediene')
            ->setAdmin(false)
            ->setName('Boumediene')
            ->setLastname('Saidi')
            ->setRoles(['ROLE_CLIENT'])
            ->setPays($manager->getRepository( Pays::class)->findOneBy(['name' => 'France']));
        $hashedPassword = $this->passwordHasher->hashPassword($user1, 'eneidemuob');
        $user4->setPassword($hashedPassword);
        $manager->persist($user4);

        $manager->flush();
    }
}
