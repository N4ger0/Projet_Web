<?php

namespace App\Service;

use App\Entity\Panier;
use Doctrine\ORM\EntityManagerInterface;

class PanierService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getArticlesDansPanier(int $clientId): int
    {
        $panierRepository = $this->entityManager->getRepository(Panier::class);
        $paniers = $panierRepository->findBy(['client'=>$clientId]);

        $counter = 0 ;
        foreach ($paniers as $panier){
            $counter+=$panier->getQuantity();
        }
        return $counter;
    }
}