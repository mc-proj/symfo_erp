<?php

namespace App\Entity;

use App\Repository\SerpProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerpProduitRepository::class)
 */
class SerpProduit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=SerpMatiereProduit::class, mappedBy="id_produit", orphanRemoval=true)
     */
    private $id_matiere_produit;

    public function __construct()
    {
        $this->id_matiere_produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|SerpMatiereProduit[]
     */
    public function getIdMatiereProduit(): Collection
    {
        return $this->id_matiere_produit;
    }

    public function addIdMatiereProduit(SerpMatiereProduit $idMatiereProduit): self
    {
        if (!$this->id_matiere_produit->contains($idMatiereProduit)) {
            $this->id_matiere_produit[] = $idMatiereProduit;
            $idMatiereProduit->setIdProduit($this);
        }

        return $this;
    }

    public function removeIdMatiereProduit(SerpMatiereProduit $idMatiereProduit): self
    {
        if ($this->id_matiere_produit->removeElement($idMatiereProduit)) {
            // set the owning side to null (unless already changed)
            if ($idMatiereProduit->getIdProduit() === $this) {
                $idMatiereProduit->setIdProduit(null);
            }
        }

        return $this;
    }
}
