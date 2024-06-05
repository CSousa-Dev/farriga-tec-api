<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Repository\Devices\TresholdRepository;

#[ORM\Entity(repositoryClass: TresholdRepository::class)]
#[ORM\Table(name: 'devices.treshold')]
class Treshold
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $configured_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $minValue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $maxValue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getConfiguredAt(): ?\DateTimeImmutable
    {
        return $this->configured_at;
    }

    public function setConfiguredAt(\DateTimeImmutable $configured_at): static
    {
        $this->configured_at = $configured_at;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getMinValue(): ?string
    {
        return $this->minValue;
    }

    public function setMinValue(?string $minValue): static
    {
        $this->minValue = $minValue;

        return $this;
    }

    public function getMaxValue(): ?string
    {
        return $this->maxValue;
    }

    public function setMaxValue(?string $maxValue): static
    {
        $this->maxValue = $maxValue;

        return $this;
    }
}
