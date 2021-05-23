<?php

namespace App\Entity;

use App\Repository\SerpMatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SerpMatiereRepository::class)
 */
class SerpMatiere
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
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite_stock;

    /**
     * @ORM\Column(type="integer")
     */
    private $limite_basse_stock;

    /**
     * @ORM\OneToMany(targetEntity=SerpMatiereProduit::class, mappedBy="id_matiere", orphanRemoval=true)
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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantite_stock;
    }

    public function setQuantiteStock(int $quantite_stock): self
    {
        $this->quantite_stock = $quantite_stock;

        return $this;
    }

    public function getLimiteBasseStock(): ?int
    {
        return $this->limite_basse_stock;
    }

    public function setLimiteBasseStock(int $limite_basse_stock): self
    {
        $this->limite_basse_stock = $limite_basse_stock;

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
            $idMatiereProduit->setIdMatiere($this);
        }

        return $this;
    }

    public function removeIdMatiereProduit(SerpMatiereProduit $idMatiereProduit): self
    {
        if ($this->id_matiere_produit->removeElement($idMatiereProduit)) {
            // set the owning side to null (unless already changed)
            if ($idMatiereProduit->getIdMatiere() === $this) {
                $idMatiereProduit->setIdMatiere(null);
            }
        }

        return $this;
    }
}
