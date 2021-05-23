<?php

namespace App\Entity;

use App\Repository\SerpMatiereProduitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerpMatiereProduitRepository::class)
 */
class SerpMatiereProduit //implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite_matiere;

    /**
     * @ORM\ManyToOne(targetEntity=SerpProduit::class, inversedBy="id_matiere_produit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_produit;

    /**
     * @ORM\ManyToOne(targetEntity=SerpMatiere::class, inversedBy="id_matiere_produit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_matiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteMatiere(): ?int
    {
        return $this->quantite_matiere;
    }

    public function setQuantiteMatiere(int $quantite_matiere): self
    {
        $this->quantite_matiere = $quantite_matiere;

        return $this;
    }

    public function getIdProduit(): ?SerpProduit
    {
        return $this->id_produit;
    }

    public function setIdProduit(?SerpProduit $id_produit): self
    {
        $this->id_produit = $id_produit;

        return $this;
    }

    public function getIdMatiere(): ?SerpMatiere
    {
        return $this->id_matiere;
    }

    public function setIdMatiere(?SerpMatiere $id_matiere): self
    {
        $this->id_matiere = $id_matiere;

        return $this;
    }
}
