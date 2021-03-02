<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepotRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="coldcash/depot/{id}"
 *      },
 *      "delete"={
 *          "path"="coldcash/depot/{id}"
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
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caissier;

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $statut;

    public function __construct()
    {
        $this->date = new DateTime();
        $this->staut = true;
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
        if ($montant < 0) {
            throw new BadRequestHttpException('Montant Incorrect!');
        }
        $this->montant = $montant;

        return $this;
    }

    public function getCaissier()
    {
        $caissier = $this->caissier;
        if ($caissier instanceof Caissier || $caissier instanceof AdminSystem) {
            return $caissier;
        }
    }

    public function setCaissier($caissier): self
    {
        if ($caissier instanceof Caissier || $caissier instanceof AdminSystem) {
            $this->caissier = $caissier;
            return $this;
        }
        throw new BadRequestHttpException("Vous n'êtes pas autorisé à faire cette opération");
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

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
