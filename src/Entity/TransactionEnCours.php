<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionEnCoursRepository;

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
 *      "get"={
 *          "path"="coldcash/transaction/retrait/{code}"
 *      },
 *      "put"={
 *          "path"="coldcash/transaction/retrait/{code}",
 *          "normalization_context"={"groups"={"transaction:depot"}},
 *          "denormalization_context"={"groups"={"transaction:retrait"}}
 *      },
 *      "delete"={
 *          "path"="coldcash/transaction/cancel/{code}",
 *      }
 *  }
 * )
 */
class TransactionEnCours extends Transaction
{
}
