<?php

namespace App\Entity;

use App\Repository\SerpIntervenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SerpIntervenantRepository::class)
 */
class SerpIntervenant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=1, max=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=1, max=255)
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity=SerpHistoriqueProduction::class, mappedBy="id_intervenant", orphanRemoval=true)
     */
    private $id_historique_production;

    /**
     * @ORM\OneToMany(targetEntity=SerpIntervention::class, mappedBy="id_intervenant", orphanRemoval=true)
     */
    private $id_intervention;

    /**
     * @ORM\ManyToOne(targetEntity=SerpTypeIntervenant::class, inversedBy="id_intervenant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_type_intervenant;

    /**
     * @ORM\OneToMany(targetEntity=SerpControleQualite::class, mappedBy="id_intervenant", orphanRemoval=true)
     */
    private $id_controle_qualite;

    public function __construct()
    {
        $this->id_historique_production = new ArrayCollection();
        $this->id_intervention = new ArrayCollection();
        $this->id_controle_qualite = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return Collection|Serphistoriqueproduction[]
     */
    public function getIdHistoriqueProduction(): Collection
    {
        return $this->id_historique_production;
    }

    public function addIdHistoriqueProduction(SerpHistoriqueProduction $idHistoriqueProduction): self
    {
        if (!$this->id_historique_production->contains($idHistoriqueProduction)) {
            $this->id_historique_production[] = $idHistoriqueProduction;
            $idHistoriqueProduction->setIdIntervenant($this);
        }

        return $this;
    }

    public function removeIdHistoriqueProduction(SerpHistoriqueProduction $idHistoriqueProduction): self
    {
        if ($this->id_historique_production->removeElement($idHistoriqueProduction)) {
            // set the owning side to null (unless already changed)
            if ($idHistoriqueProduction->getIdIntervenant() === $this) {
                $idHistoriqueProduction->setIdIntervenant(null);
            }
        }

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
            $idIntervention->setIdIntervenant($this);
        }

        return $this;
    }

    public function removeIdIntervention(SerpIntervention $idIntervention): self
    {
        if ($this->id_intervention->removeElement($idIntervention)) {
            // set the owning side to null (unless already changed)
            if ($idIntervention->getIdIntervenant() === $this) {
                $idIntervention->setIdIntervenant(null);
            }
        }

        return $this;
    }

    public function getIdTypeIntervenant(): ?SerpTypeIntervenant
    {
        return $this->id_type_intervenant;
    }

    public function setIdTypeIntervenant(?SerpTypeIntervenant $id_type_intervenant): self
    {
        $this->id_type_intervenant = $id_type_intervenant;

        return $this;
    }

    /**
     * @return Collection|SerpControleQualite[]
     */
    public function getIdControleQualite(): Collection
    {
        return $this->id_controle_qualite;
    }

    public function addIdControleQualite(SerpControleQualite $idControleQualite): self
    {
        if (!$this->id_controle_qualite->contains($idControleQualite)) {
            $this->id_controle_qualite[] = $idControleQualite;
            $idControleQualite->setIdIntervenant($this);
        }

        return $this;
    }

    public function removeIdControleQualite(Serpcontrolequalite $idControleQualite): self
    {
        if ($this->id_controle_qualite->removeElement($idControleQualite)) {
            // set the owning side to null (unless already changed)
            if ($idControleQualite->getIdIntervenant() === $this) {
                $idControleQualite->setIdIntervenant(null);
            }
        }

        return $this;
    }
}
