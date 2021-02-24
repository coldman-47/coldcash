<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionEnCoursRepository;

/**
 * @ORM\Entity(repositoryClass=TransactionEnCoursRepository::class)
 * @ApiResource
 */
class TransactionEnCours extends Transaction
{
}
