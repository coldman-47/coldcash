<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FraisRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;

/**
 * @ORM\Entity(repositoryClass=FraisRepository::class)
 * @ApiResource(
 *  routePrefix = "/coldcash"
 * )
 * @ApiFilter(RangeFilter::class, properties={"minimum", "maximum"})
 */
class Frais
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
    private $minimum;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $maximum;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tarif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinimum(): ?float
    {
        return $this->minimum;
    }

    public function setMinimum(float $minimum): self
    {
        $this->minimum = $minimum;

        return $this;
    }

    public function getMaximum(): ?float
    {
        return $this->maximum;
    }

    public function setMaximum(float $maximum): self
    {
        $this->maximum = $maximum;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }
}
