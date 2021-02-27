<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="etat", type="string")
 * @DiscriminatorMap({"tous" = "Transaction", "reussie" = "TransactionTermine", "encours" = "TransactionEnCours"})
 * @ApiResource(
 *  collectionOperations={
 *      "get"={
 *          "path"="coldcash/transactions"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="coldcash/transactions/{code}"
 *      }
 *  }
 * )
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ApiProperty(identifier=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"transaction:depot"})
     */
    protected $montant;

    /**
     * @ORM\Column(type="date")
     * @Groups({"transaction:depot"})
     */
    protected $dateDepot;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dateRetrait;

    /**
     * @ORM\Column(type="float")
     */
    protected $frais;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $fraisEtat;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $fraisSystem;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $fraisDepot;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $fraisRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:depot"})
     * @ApiProperty(identifier=true)
     */
    protected $code;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction:depot"})
     */
    protected $agentDepot;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="retraits")
     */
    protected $agentRetrait;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="envois", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction:depot"})
     */
    protected $envoyeur;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="retraits", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction:depot"})
     */
    protected $receveur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id, $key): self
    {
        if (isset($key['item_operation_name']) && $key['item_operation_name'] === 'put') {
            $this->id = $id;
        }
        return $this;
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

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

        return $this;
    }

    public function getFraisEtat(): ?float
    {
        return $this->fraisEtat;
    }

    public function setFraisEtat(?float $fraisEtat): self
    {
        $this->fraisEtat = $fraisEtat;

        return $this;
    }

    public function getFraisSystem(): ?float
    {
        return $this->fraisSystem;
    }

    public function setFraisSystem(?float $fraisSystem): self
    {
        $this->fraisSystem = $fraisSystem;

        return $this;
    }

    public function getFraisDepot(): ?float
    {
        return $this->fraisDepot;
    }

    public function setFraisDepot(?float $fraisDepot): self
    {
        $this->fraisDepot = $fraisDepot;

        return $this;
    }

    public function getFraisRetrait(): ?float
    {
        return $this->fraisRetrait;
    }

    public function setFraisRetrait(?float $fraisRetrait): self
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

    public function getEnvoyeur(): ?Client
    {
        return $this->envoyeur;
    }

    public function setEnvoyeur(?Client $envoyeur): self
    {
        $this->envoyeur = $envoyeur;

        return $this;
    }

    public function getReceveur(): ?Client
    {
        return $this->receveur;
    }

    public function setReceveur(?Client $receveur): self
    {
        $this->receveur = $receveur;

        return $this;
    }
}
