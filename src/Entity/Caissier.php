<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CaissierRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=CaissierRepository::class)
 * @ApiResource(
 *  attributes = {
 *      "pagination_items_per_page"=10,  
 *      "security" = "is_granted('ROLE_ADMINSYSTEM')"
 *  },
 *  collectionOperations={
 *      "get"={
 *          "path"="coldcash/caissiers"
 *      },
 *      "post"={
 *          "path"="coldcash/caissiers"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="coldcash/caissier/{id}"
 *      }
 *  }
 * )
 */
class Caissier extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="caissier")
     */
    private $depots;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
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
            $depot->setCaissier($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getCaissier() === $this) {
                $depot->setCaissier(null);
            }
        }

        return $this;
    }
}
