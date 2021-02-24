<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionTermineRepository;

/**
 * @ORM\Entity(repositoryClass=TransactionTermineRepository::class)
 * @ApiResource
 */
class TransactionTermine extends Transaction
{
}
