<?php

namespace App\Entity;

use App\Repository\SerpTypeInterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerpTypeInterventionRepository::class)
 */
class SerpTypeIntervention
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
     * @ORM\OneToMany(targetEntity=SerpIntervention::class, mappedBy="id_type_intervention", orphanRemoval=true)
     */
    private $id_intervention;

    public function __construct()
    {
        $this->id_intervention = new ArrayCollection();
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
     * @return Collection|SerpIntervention[]
     */
    public function getIdIntervention(): Collection
    {
        return $this->id_intervention;
    }

    public function addIdIntervention(SerpIntervention $idIntervention): self
    {
        if (!$this->id_intervention->contains($idIntervention)) {
            $this->id_intervention[] = $idIntervention;
            $idIntervention->setIdTypeIntervention($this);
        }

        return $this;
    }

    public function removeIdIntervention(SerpIntervention $idIntervention): self
    {
        if ($this->id_intervention->removeElement($idIntervention)) {
            // set the owning side to null (unless already changed)
            if ($idIntervention->getIdTypeIntervention() === $this) {
                $idIntervention->setIdTypeIntervention(null);
            }
        }

        return $this;
    }
}
