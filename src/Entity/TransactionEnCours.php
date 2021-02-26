<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionEnCoursRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=TransactionEnCoursRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *      "post"={
 *          "path"="coldcash/transaction/depot",
 *          "security"="is_granted('ROLE_AGENT') or is_granted('ROLE_ADMINAGENCE')",
 *          "denormalization_context"={"groups"={"transaction:depot"}}
 *      },
 *      "get"={
 *          "path"="coldcash/transaction/depot",
 *          "security"="is_granted('ROLE_AGENT') or is_granted('ROLE_ADMINAGENCE')"
 *      }
 *  },
 *  itemOperations={
 *      "put"={
 *          "path"="coldcash/transaction/retrait/{code}"
 *      }
 *  }
 * )
 */
class TransactionEnCours extends Transaction
{
}
