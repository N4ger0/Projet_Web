<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'lic_panier')]
#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(
        targetEntity: User::class,
        inversedBy: 'client'
    )]
    #[ORM\JoinColumn(
        name : 'id_user',
        referencedColumnName: 'id',
        nullable: false,
    )]
    private ?User $client = null;

    #[ORM\ManyToOne(
        targetEntity: Produit::class,
        inversedBy: 'produit'
    )]
    #[ORM\JoinColumn(
        name : 'id_produit',
        referencedColumnName: 'id',
        nullable: false,
    )]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(User $Client): static
    {
        $this->client = $Client;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
