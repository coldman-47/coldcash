<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="etat", type="string")
 * @DiscriminatorMap({"tous" = "Transaction", "reussie" = "TransactionTermine", "encours" = "TransactionEnCours"})
 * @ApiResource
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $frais;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fraisEtat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fraisSystem;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fraisDepot;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fraisRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agentDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="retraits")
     */
    private $agentRetrait;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->dateDepot;
    }

    public function setDateDepot(\DateTimeInterface $dateDepot): self
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getFraisEtat(): ?int
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(?int $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getFraisSystem(): ?int
    {
        return $this->fraisSystem;
    }

    public function setFraisSystem(?int $fraisSystem): self
    {
        $this->fraisSystem = $fraisSystem;

        return $this;
    }

    public function getFraisDepot(): ?int
    {
        return $this->fraisDepot;
    }

    public function setFraisDepot(?int $fraisDepot): self
    {
        $this->fraisDepot = $fraisDepot;

        return $this;
    }

    public function getFraisRetrait(): ?int
    {
        return $this->fraisRetrait;
    }

    public function setFraisRetrait(?int $fraisRetrait): self
    {
        $this->fraisRetrait = $fraisRetrait;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getAgentDepot(): ?Agent
    {
        return $this->agentDepot;
    }

    public function setAgentDepot(?Agent $agentDepot): self
    {
        $this->agentDepot = $agentDepot;

        return $this;
    }

    public function getAgentRetrait(): ?Agent
    {
        return $this->agentRetrait;
    }

    public function setAgentRetrait(?Agent $agentRetrait): self
    {
        $this->agentRetrait = $agentRetrait;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
