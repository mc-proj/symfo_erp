<?php

namespace App\Entity;

use App\Repository\SerpControleQualiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerpControleQualiteRepository::class)
 */
class SerpControleQualite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite_controlee;

    /**
     * @ORM\ManyToOne(targetEntity=SerpIntervenant::class, inversedBy="id_controle_qualite")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $id_intervenant;

    /**
     * @ORM\ManyToOne(targetEntity=SerpOf::class, inversedBy="serpControleQualites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $of_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getQuantiteControlee(): ?int
    {
        return $this->quantite_controlee;
    }

    public function setQuantiteControlee(int $quantite_controlee): self
    {
        $this->quantite_controlee = $quantite_controlee;

        return $this;
    }

    public function getIdIntervenant(): ?SerpIntervenant
    {
        return $this->id_intervenant;
    }

    public function setIdIntervenant(?SerpIntervenant $id_intervenant): self
    {
        $this->id_intervenant = $id_intervenant;

        return $this;
    }

    public function getOfId(): ?SerpOf
    {
        return $this->of_id;
    }

    public function setOfId(?SerpOf $of_id): self
    {
        $this->of_id = $of_id;

        return $this;
    }
}
