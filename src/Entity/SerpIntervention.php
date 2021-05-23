<?php

namespace App\Entity;

use App\Repository\SerpInterventionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SerpInterventionRepository::class)
 */
class SerpIntervention
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $observation;

    /**
     * @ORM\ManyToOne(targetEntity=SerpTypeIntervention::class, inversedBy="id_intervention")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $id_type_intervention;

    /**
     * @ORM\ManyToOne(targetEntity=SerpMachine::class, inversedBy="id_intervention")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $id_machine;

    /**
     * @ORM\ManyToOne(targetEntity=SerpIntervenant::class, inversedBy="id_intervention")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
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

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    public function getIdTypeIntervention(): ?SerpTypeIntervention
    {
        return $this->id_type_intervention;
    }

    public function setIdTypeIntervention(?SerpTypeIntervention $id_type_intervention): self
    {
        $this->id_type_intervention = $id_type_intervention;

        return $this;
    }

    public function getIdMachine(): ?SerpMachine
    {
        return $this->id_machine;
    }

    public function setIdMachine(?SerpMachine $id_machine): self
    {
        $this->id_machine = $id_machine;

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
