<?php

namespace App\Entity;

use App\Entity\Transaction;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"admin" = "AdminSystem", "caissier" = "Caissier", "adminAgence" = "AdminAgence", "agent"="Agent", "user" = "User"})
 * @ApiResource(
 * attributes = {
 *      "pagination_items_per_page"=10  
 *  },
 *  collectionOperations={
 *      "get"={
 *          "path"="coldcash/admin/users",
 *          "security" = "is_granted('ROLE_ADMINSYSTEM')"
 *      }
 *  },
 *  itemOperations={
 *      "get"={
 *          "path"="coldcash/user/{id}",
 *          "security" = "is_granted('ROLE_ADMINSYSTEM') or user.getId() == object.getId()"
 *      }
 *  }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("adminAgence")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups("adminAgence")
     */
    protected $username;

    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("adminAgence")
     */
    protected $password;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("adminAgence")
     */
    protected $profil;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("adminAgence")
     */
    protected $nom;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $statut;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="agentDepot")
     */
    protected $envois;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="agentRetrait")
     */
    protected $retraits;


    /**
     * @ORM\OneToMany(targetEntity=Depot::class, mappedBy="caissier")
     */
    protected $depots;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->retraits = new ArrayCollection();
        $this->depots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        if (!$this->getStatut()) {
            $roles[] = 'ROLE_DENIED';
        } else {
            $roles[] = 'ROLE_' . strtoupper($this->profil->getLibelle());
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getAvatar()
    {
        $photo = $this->avatar;
        return is_resource($photo) ? base64_encode(stream_get_contents($photo)) : $photo;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getEnvois(): Collection
    {
        return $this->envois;
    }

    public function addEnvoi(Transaction $depot): self
    {
        if (!$this->envois->contains($depot)) {
            $this->envois[] = $depot;
            $depot->setAgentDepot($this);
        }

        return $this;
    }

    public function removeEnvoi(Transaction $depot): self
    {
        if ($this->envois->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getAgentDepot() === $this) {
                $depot->setAgentDepot(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getRetraits(): Collection
    {
        return $this->retraits;
    }

    public function addRetrait(Transaction $retrait): self
    {
        if (!$this->retraits->contains($retrait)) {
            $this->retraits[] = $retrait;
            $retrait->setAgentRetrait($this);
        }

        return $this;
    }

    public function removeRetrait(Transaction $retrait): self
    {
        if ($this->retraits->removeElement($retrait)) {
            // set the owning side to null (unless already changed)
            if ($retrait->getAgentRetrait() === $this) {
                $retrait->setAgentRetrait(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCaissier($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getCaissier() === $this) {
                $depot->setCaissier(null);
            }
        }

        return $this;
    }
}
