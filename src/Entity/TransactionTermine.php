<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionTermineRepository;

/**
 * @ORM\Entity(repositoryClass=TransactionTermineRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *      "get"={
 *          "path"="coldcash/transactions/retires"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="coldcash/transaction/retrait/{code}"
 *      }
 *  }
 * )
 */
class TransactionTermine extends Transaction
{
}
