<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AgenceRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or is_granted('ROLE_CAISSIER')",
 *          "path"="coldcash/agences"
 *      },
 *      "post"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM')",
 *          "path"="coldcash/agences"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or (user.getAgence() == object) or is_granted('ROLE_CAISSIER')",
 *          "path"="coldcash/agence/{id}",
 *          "normalization_context"={"groups"={"agence:info"}}
 *      },
 *      "put"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or is_granted('ROLE_CAISSIER')",
 *          "path"="coldcash/agence/{id}",
 *          "denormalization_context"={"groups"={"agence:newInfo"}}
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
     * @Groups({"agence:info"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"agence:info", "agence:newInfo"})
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     * @Groups({"agence:info", "agence:newInfo"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="float")
     * @Groups({"agence:info"})
     * @Groups({"transaction:retrait"})
     */
    private $solde;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Agent::class, mappedBy="agence", orphanRemoval=true)
     * @Groups({"agence:info"})
     */
    private $agents;

    /**
     * @ORM\OneToOne(targetEntity=AdminAgence::class, inversedBy="agence", cascade={"persist", "remove"})
     */
    private $admin;

    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="agence")
     */
    private $depots;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->statut = true;
        $this->solde = 700000;
        $this->depots = new ArrayCollection();
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
        $this->solde += $solde;

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

    public function setAdmin(?AdminAgence $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setAgence($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getAgence() === $this) {
                $depot->setAgence(null);
            }
        }

        return $this;
    }
}
