<?php

namespace App\Entity;

use App\Repository\SerpTypeIntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SerpTypeIntervenantRepository::class)
 */
class SerpTypeIntervenant
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
    private $intitule;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=SerpIntervenant::class, mappedBy="id_type_intervenant", orphanRemoval=true)
     */
    private $id_intervenant;

    public function __construct()
    {
        $this->id_intervenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection|SerpIntervenant[]
     */
    public function getIdIntervenant(): Collection
    {
        return $this->id_intervenant;
    }

    public function addIdIntervenant(SerpIntervenant $idIntervenant): self
    {
        if (!$this->id_intervenant->contains($idIntervenant)) {
            $this->id_intervenant[] = $idIntervenant;
            $idIntervenant->setIdTypeIntervenant($this);
        }

        return $this;
    }

    public function removeIdIntervenant(SerpIntervenant $idIntervenant): self
    {
        if ($this->id_intervenant->removeElement($idIntervenant)) {
            // set the owning side to null (unless already changed)
            if ($idIntervenant->getIdTypeIntervenant() === $this) {
                $idIntervenant->setIdTypeIntervenant(null);
            }
        }

        return $this;
    }
}
