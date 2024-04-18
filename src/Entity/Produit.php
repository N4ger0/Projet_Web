<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?float $prixunit = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToMany(targetEntity: Pays::class, inversedBy: 'produits')]
    #[ORM\JoinTable(name: 'asso_pays_produits')]
    #[ORM\JoinColumn(name: 'id_pays', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'id_produit', referencedColumnName: 'id')]
    private Collection $Pays;

    public function __construct()
    {
        $this->Pays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrixunit(): ?float
    {
        return $this->prixunit;
    }

    public function setPrixunit(float $prixunit): static
    {
        $this->prixunit = $prixunit;

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

    /**
     * @return Collection<int, Pays>
     */
    public function getPays(): Collection
    {
        return $this->Pays;
    }

    public function addPay(Pays $pay): static
    {
        if (!$this->Pays->contains($pay)) {
            $this->Pays->add($pay);
        }

        return $this;
    }

    public function removePay(Pays $pay): static
    {
        $this->Pays->removeElement($pay);

        return $this;
    }
}
