<?php

namespace App\Entity;

use App\Repository\SerpOfRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SerpOfRepository::class)
 */
class SerpOf
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(0)
     */
    private $quantite_commandee;

    /**
     * @ORM\ManyToOne(targetEntity=SerpClient::class, inversedBy="id_of")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $id_client;

    /**
     * @ORM\OneToMany(targetEntity=SerpHistoriqueProduction::class, mappedBy="id_of")
     */
    private $id_historique_production;

    /**
     * @ORM\OneToMany(targetEntity=SerpControleQualite::class, mappedBy="of_id", orphanRemoval=true)
     */
    private $serpControleQualites;

    /**
     * @ORM\Column(type="date")
     */
    private $date_commande;

    /**
     * @ORM\ManyToOne(targetEntity=SerpMachine::class, inversedBy="of_id")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $machine_id;

    public function __construct()
    {
        $this->id_historique_production = new ArrayCollection();
        $this->serpControleQualites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteCommandee(): ?int
    {
        return $this->quantite_commandee;
    }

    public function setQuantiteCommandee(int $quantite_commandee): self
    {
        $this->quantite_commandee = $quantite_commandee;

        return $this;
    }

    public function getIdClient(): ?SerpClient
    {
        return $this->id_client;
    }

    public function setIdClient(?SerpClient $id_client): self
    {
        $this->id_client = $id_client;

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
            $idHistoriqueProduction->setIdOf($this);
        }

        return $this;
    }

    public function removeIdHistoriqueProduction(SerpHistoriqueProduction $idHistoriqueProduction): self
    {
        if ($this->id_historique_production->removeElement($idHistoriqueProduction)) {
            // set the owning side to null (unless already changed)
            if ($idHistoriqueProduction->getIdOf() === $this) {
                $idHistoriqueProduction->setIdOf(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SerpControleQualite[]
     */
    public function getSerpControleQualites(): Collection
    {
        return $this->serpControleQualites;
    }

    public function addSerpControleQualite(SerpControleQualite $serpControleQualite): self
    {
        if (!$this->serpControleQualites->contains($serpControleQualite)) {
            $this->serpControleQualites[] = $serpControleQualite;
            $serpControleQualite->setOfId($this);
        }

        return $this;
    }

    public function removeSerpControleQualite(SerpControleQualite $serpControleQualite): self
    {
        if ($this->serpControleQualites->removeElement($serpControleQualite)) {
            // set the owning side to null (unless already changed)
            if ($serpControleQualite->getOfId() === $this) {
                $serpControleQualite->setOfId(null);
            }
        }

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getMachineId(): ?SerpMachine
    {
        return $this->machine_id;
    }

    public function setMachineId(?SerpMachine $machine_id): self
    {
        $this->machine_id = $machine_id;

        return $this;
    }
}
