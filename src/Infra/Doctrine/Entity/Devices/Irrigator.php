<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Entity\Devices\Zone;
use App\Infra\Doctrine\Entity\Devices\IrrigatorType;
use App\Infra\Doctrine\Repository\Devices\IrrigatorRepository;

#[ORM\Entity(repositoryClass: IrrigatorRepository::class)]
#[ORM\Table(name: 'devices.irrigator')]
class Irrigator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'irrgators')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Zone $zone = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\ManyToOne(inversedBy: 'irrigators')]
    #[ORM\JoinColumn(nullable: false)]
    private ?IrrigatorType $irrigatorType = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(length: 255)]
    private ?string $alias = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function number()
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): static
    {
        $this->zone = $zone;

        return $this;
    }


    public function getIrrigatorType(): IrrigatorType
    {
        return $this->irrigatorType;
    }

    public function setIrrigatorType(IrrigatorType $irrigatorType): static
    {
        $this->irrigatorType = $irrigatorType;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
