<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use App\Repository\AdminAgenceRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotNull;

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
 *      },
 *      "post"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM')",
 *          "path"="agence/admins",
 *          "denormalization_context"={"groups"={"adminAgence"}}
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or user.getId() == object.getId()",
 *          "path"="agence/admin/{id}"
 *      },
 *      "put"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or user.getId() == object.getId()",
 *          "path"="agence/admin/{id}"
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
     * @Groups({"transaction:retrait"})
     */
    private $agence;

    public function __construct()
    {
        $this->roles[] = 'ROLE_AGENT';
    }

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
