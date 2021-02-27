<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"transaction:depot", "transaction:retrait"})
     */
    private $cni;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:depot", "transaction:retrait"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:depot", "transaction:retrait"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction:depot", "transaction:retrait"})
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="envoyeur")
     */
    private $envois;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="receveur")
     */
    private $retraits;

    public function __construct()
    {
        $this->envois = new ArrayCollection();
        $this->retraits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(?string $cni): self
    {
        $this->cni = $cni;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getEnvois(): Collection
    {
        return $this->envois;
    }

    public function addEnvoi(Transaction $envoi): self
    {
        if (!$this->envois->contains($envoi)) {
            $this->envois[] = $envoi;
            $envoi->setEnvoyeur($this);
        }

        return $this;
    }

    public function removeEnvoi(Transaction $envoi): self
    {
        if ($this->envois->removeElement($envoi)) {
            // set the owning side to null (unless already changed)
            if ($envoi->getEnvoyeur() === $this) {
                $envoi->setEnvoyeur(null);
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
            $retrait->setReceveur($this);
        }

        return $this;
    }

    public function removeRetrait(Transaction $retrait): self
    {
        if ($this->retraits->removeElement($retrait)) {
            // set the owning side to null (unless already changed)
            if ($retrait->getReceveur() === $this) {
                $retrait->setReceveur(null);
            }
        }

        return $this;
    }
}
