<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *      "get"={
 *          "path"="coldcash/agences"
 *      },
 *      "post"={
 *          "path"="coldcash/agences"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="coldcash/agences"
 *      }
 *  }
 * )
 */
class Agence
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
     * @ORM\Column(type="text")
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Agent::class, mappedBy="agence", orphanRemoval=true)
     */
    private $agents;

    /**
     * @ORM\OneToOne(targetEntity=AdminAgence::class, inversedBy="agence", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $admin;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->statut = true;
        $this->solde = 700000;
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

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Agent[]
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->setAgence($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getAgence() === $this) {
                $agent->setAgence(null);
            }
        }

        return $this;
    }

    public function getAdmin(): ?AdminAgence
    {
        return $this->admin;
    }

    public function setAdmin(AdminAgence $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
