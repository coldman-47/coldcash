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
    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="transactionTermines")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agenceRetrait;

    public function getAgenceRetrait(): ?Agence
    {
        return $this->agenceRetrait;
    }

    public function setAgenceRetrait(?Agence $agenceRetrait): self
    {
        $this->agenceRetrait = $agenceRetrait;

        return $this;
    }
}
