<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepotRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=DepotRepository::class)
 * @ApiResource(
 *  attributes={
 *      "security" = "is_granted('ROLE_CAISSIER')"
 *  },
 *  collectionOperations={
 *      "get"={
 *          "path"="coldcash/depots"
 *      },
 *      "post"={
 *          "path"="coldcash/depots"
 *      }
 *  }
 * )
 */
class Depot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=Caissier::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caissier;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function __construct()
    {
        $this->date = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getCaissier(): ?Caissier
    {
        return $this->caissier;
    }

    public function setCaissier(?Caissier $caissier): self
    {
        $this->caissier = $caissier;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->agence;
    }

    public function setAgence(?Agence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
