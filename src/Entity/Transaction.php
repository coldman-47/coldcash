<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Id\IdentityGenerator;
use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @ApiFilter(DateFilter::class, properties={"dateDepot": "exact", "dateRetrait": "exact"})
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="etat", type="string")
 * @DiscriminatorMap({"tous" = "Transaction","reussie"="TransactionTermine", "encours" = "TransactionEnCours"})
 * @ApiResource(
 *  mercure=true,
 *  collectionOperations={
 *      "get"={
 *          "path"="coldcash/transactions"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="coldcash/transaction/{code}"
 *      }
 *  }
 * )
 */
class Transaction
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id", nullable=false)
     * @ApiProperty(identifier=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"transaction:depot", "user"})
     */
    protected $montant;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("user")
     */
    protected $dateDepot;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("user")
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
     * @Groups("user")
     */
    protected $fraisDepot;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("user")
     */
    protected $fraisRetrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @ApiProperty(identifier=true)
     */
    protected $code;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="envois")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user"})
     */
    protected $agentDepot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="retraits")
     * @Groups({"user"})
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
     * @Groups({"transaction:depot", "transaction:retrait"})
     */
    protected $receveur;

    private $deny = "Accès refusé!";

    /**
     * @ORM\ManyToOne(targetEntity=Agence::class, inversedBy="transactionsDepot")
     * @ORM\JoinColumn(nullable=true)
     */
    private $agenceDepot;

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

    public function getAgentDepot()
    {
        $operateur = $this->agentDepot;
        if ($operateur && !($operateur instanceof Agent || $operateur instanceof AdminAgence)) {
            throw new BadRequestHttpException($this->deny);
        }
        return $operateur;
    }

    public function setAgentDepot($agentDepot): self
    {
        if ($agentDepot instanceof Agent || $agentDepot instanceof AdminAgence) {
            $this->agentDepot = $agentDepot;
            return $this;
        }
        throw new BadRequestHttpException($this->deny);
    }

    public function getAgentRetrait()
    {
        $operateur = $this->agentRetrait;
        if ($operateur && !($operateur instanceof Agent || $operateur instanceof AdminAgence)) {
            throw new BadRequestHttpException($this->deny);
        }
        return $operateur;
    }

    public function setAgentRetrait($agentRetrait): self
    {
        if ($agentRetrait instanceof Agent || $agentRetrait instanceof AdminAgence) {
            $this->agentRetrait = $agentRetrait;
            return $this;
        }
        throw new BadRequestHttpException($this->deny);
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

    public function getAgenceDepot(): ?Agence
    {
        return $this->agenceDepot;
    }

    public function setAgenceDepot(?Agence $agenceDepot): self
    {
        $this->agenceDepot = $agenceDepot;

        return $this;
    }
}
