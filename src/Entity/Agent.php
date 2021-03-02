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
 *          "path"="agence/user",
 *          "deserialize"=false
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or (is_granted('ROLE_ADMINAGENCE') and object.getAgence() == user.getAgence()) or object.getId() == user.getId()",
 *          "path"="agence/user/{id}"
 *      },
 *      "put"={
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or (is_granted('ROLE_ADMINAGENCE') and object.getAgence() == user.getAgence()) or object.getId() == user.getId()",
 *          "path"="agence/user/{id}",
 *          "deserialize"=false
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
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="agents", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction:retrait"})
     */
    private $agence;

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
