<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdminSystemRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=AdminSystemRepository::class)
 * @ApiResource(
 * attributes = {
 *      "pagination_items_per_page"=10,  
 *      "security" = "is_granted('ROLE_ADMINSYSTEM')"
 *  },
 *  collectionOperations={
 *      "post"={
 *          "path"="coldcash/admin"
 *      },
 *      "get"={
 *          "path"="coldcash/admin"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="coldcash/admin/{id}"
 *      },
 *      "put"={
 *          "path"="coldcash/admin/{id}",
 *          "security" = "user.getId() == object.getId()"
 *      }
 *  }
 * )
 */
class AdminSystem extends User
{
}
