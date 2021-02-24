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
 *      "security" = "is_granted('ROLE_ADMINSYSTEM')"
 *  },
 *  collectionOperations={
 *      "get"={
 *          "path"="agence/admins"
 *      },
 *      "post"={
 *          "path"="agence/admins",
 *          "denormalization_context"={"groups"={"adminAgence"}}
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="agence/admin/{id}"
 *      }
 *  }
 * )
 */
class AdminAgence extends User
{
    /**
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"adminAgence"})
     * @Assert\NotNull
     */
    private $agence;

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(Agence $agence): self
    {
        // set the owning side of the relation if necessary
        if ($agence->getAdmin() !== $this) {
            $agence->setAdmin($this);
        }

        $this->agence = $agence;

        return $this;
    }
}
