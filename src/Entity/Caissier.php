<?php

namespace App\Entity;

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
 *          "path"="coldcash/caissier"
 *      },
 *      "post"={
 *          "path"="coldcash/caissier"
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
}
