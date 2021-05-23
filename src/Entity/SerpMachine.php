<?php

namespace App\Entity;

use App\Repository\SerpMachineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerpMachineRepository::class)
 */
class SerpMachine
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
     * @ORM\OneToMany(targetEntity=SerpIntervention::class, mappedBy="id_machine", orphanRemoval=true)
     */
    private $id_intervention;

    
    /**
     * @ORM\OneToMany(targetEntity=SerpOf::class, mappedBy="machine_id", orphanRemoval=true)
     */
    private $of_id;

    public function __construct()
    {
        $this->id_intervention = new ArrayCollection();
        $this->of_id = new ArrayCollection();
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
            $idIntervention->setIdMachine($this);
        }

        return $this;
    }

    public function removeIdIntervention(SerpIntervention $idIntervention): self
    {
        if ($this->id_intervention->removeElement($idIntervention)) {
            // set the owning side to null (unless already changed)
            if ($idIntervention->getIdMachine() === $this) {
                $idIntervention->setIdMachine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SerpOf[]
     */
    public function getOfId(): Collection
    {
        return $this->of_id;
    }

    public function addOfId(SerpOf $ofId): self
    {
        if (!$this->of_id->contains($ofId)) {
            $this->of_id[] = $ofId;
            $ofId->setMachineId($this);
        }

        return $this;
    }

    public function removeOfId(SerpOf $ofId): self
    {
        if ($this->of_id->removeElement($ofId)) {
            // set the owning side to null (unless already changed)
            if ($ofId->getMachineId() === $this) {
                $ofId->setMachineId(null);
            }
        }

        return $this;
    }
}
