<?php

namespace App\Entity;

use App\Repository\SerpHistoriqueProductionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SerpHistoriqueProductionRepository::class)
 */
class SerpHistoriqueProduction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\LessThan(propertyPath="date_fin", message="La date de début doit etre avant la date de fin")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan(propertyPath="date_debut", message="La date de fin doit etre après la date de début")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThan(propertyPath="quantite_fin", message="La quantité de fin doit etre inférieure à la quantité de fin")
     */
    private $quantite_debut;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThan(propertyPath="quantite_debut", message="La quantité de fin doit etre supérieure à la quantité de début")
     */
    private $quantite_fin;

    /**
     * @ORM\ManyToOne(targetEntity=SerpOf::class, inversedBy="id_historique_production")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $id_of;

    /**
     * @ORM\ManyToOne(targetEntity=SerpIntervenant::class, inversedBy="id_historique_production")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_intervenant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getQuantiteDebut(): ?int
    {
        return $this->quantite_debut;
    }

    public function setQuantiteDebut(int $quantite_debut): self
    {
        $this->quantite_debut = $quantite_debut;

        return $this;
    }

    public function getQuantiteFin(): ?int
    {
        return $this->quantite_fin;
    }

    public function setQuantiteFin(?int $quantite_fin): self
    {
        $this->quantite_fin = $quantite_fin;

        return $this;
    }

    public function getIdOf(): ?SerpOf
    {
        return $this->id_of;
    }

    public function setIdOf(?SerpOf $id_of): self
    {
        $this->id_of = $id_of;

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
}
