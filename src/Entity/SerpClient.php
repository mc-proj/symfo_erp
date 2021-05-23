<?php

namespace App\Entity;

use App\Repository\SerpClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SerpClientRepository::class)
 */
class SerpClient
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
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=1, max=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\Length(min=1, max=25)
     */
    private $code_postal;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=1, max=50)
     */
    private $pays;

    /**
     * @ORM\OneToMany(targetEntity=SerpOf::class, mappedBy="id_client", orphanRemoval=true)
     */
    private $id_of;

    public function __construct()
    {
        $this->id_of = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection|SerpOf[]
     */
    public function getIdOf(): Collection
    {
        return $this->id_of;
    }

    public function addIdOf(SerpOf $idOf): self
    {
        if (!$this->id_of->contains($idOf)) {
            $this->id_of[] = $idOf;
            $idOf->setIdClient($this);
        }

        return $this;
    }

    public function removeIdOf(SerpOf $idOf): self
    {
        if ($this->id_of->removeElement($idOf)) {
            // set the owning side to null (unless already changed)
            if ($idOf->getIdClient() === $this) {
                $idOf->setIdClient(null);
            }
        }

        return $this;
    }
}
