<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AgentRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 * @ApiResource(
 * attributes = {
 *      "pagination_items_per_page"=10
 *  },
 *  collectionOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM')",
 *          "path"="agence/user"
 *      },
 *      "post"={
 *          "security" = "is_granted('ROLE_ADMINAGENCE')",
 *          "path"="agence/user"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or (is_granted('ROLE_ADMINAGENCE') and object.getAgence() == user.getAgence()) or object.getId() == user.getId()",
 *          "path"="agence/user/{id}"
 *      },
 *      "put"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or (is_granted('ROLE_ADMINAGENCE') and object.getAgence() == user.getAgence()) or object.getId() == user.getId()",
 *          "path"="agence/user/{id}"
 *      },
 *      "delete"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or (is_granted('ROLE_ADMINAGENCE') and object.getAgence() == user.getAgence())",
 *          "path"="agence/user/{id}"
 *      }
 *  }
 * )
 */
class Agent extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="agentDepot")
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="agentRetrait")
     */
    private $retraits;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="agents", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction:retrait"})
     */
    private $agence;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->retraits = new ArrayCollection();
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Transaction $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setAgentDepot($this);
        }

        return $this;
    }

    public function removeDepot(Transaction $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getAgentDepot() === $this) {
                $depot->setAgentDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getRetraits(): Collection
    {
        return $this->retraits;
    }

    public function addRetrait(Transaction $retrait): self
    {
        if (!$this->retraits->contains($retrait)) {
            $this->retraits[] = $retrait;
            $retrait->setAgentRetrait($this);
        }

        return $this;
    }

    public function removeRetrait(Transaction $retrait): self
    {
        if ($this->retraits->removeElement($retrait)) {
            // set the owning side to null (unless already changed)
            if ($retrait->getAgentRetrait() === $this) {
                $retrait->setAgentRetrait(null);
            }
        }

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }
}
