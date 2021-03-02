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
 *  },
 *  collectionOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM')",
 *          "path"="coldcash/caissiers"
 *      },
 *      "post"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM')",
 *          "path"="coldcash/caissier",
 *          "deserialize"=false
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') || user.getId() == object.getId()",
 *          "path"="coldcash/caissier/{id}"
 *      },
 *      "delete"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') || user.getId() == object.getId()",
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
    protected $depots;

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
