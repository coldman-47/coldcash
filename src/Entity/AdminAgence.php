<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminAgenceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdminAgenceRepository::class)
 * @ApiResource(
 *  attributes = {
 *      "pagination_items_per_page"=10,  
 *  },
 *  collectionOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM')",
 *          "path"="agence/admins"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or user.getId() == object.getId()",
 *          "path"="agence/admin/{id}"
 *      },
 *      "put"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or user.getId() == object.getId()",
 *          "path"="agence/admin/{id}",
 *          "deserialize"=false
 *      },
 *      "delete"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM')",
 *          "path"="agence/admin/{id}"
 *      }
 *  }
 * )
 */
class AdminAgence extends User
{
    /**
     * @ORM\OneToOne(targetEntity=Agence::class, mappedBy="admin", cascade={"persist", "remove"})
     * @Groups({"transaction:retrait", "user", "agence:add"})
     */
    private $agence;

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        // unset the owning side of the relation if necessary
        if ($agence === null && $this->agence !== null) {
            $this->agence->setAdmin(null);
        }

        // set the owning side of the relation if necessary
        if ($agence !== null && $agence->getAdmin() !== $this) {
            $agence->setAdmin($this);
        }

        $this->agence = $agence;

        return $this;
    }
}
