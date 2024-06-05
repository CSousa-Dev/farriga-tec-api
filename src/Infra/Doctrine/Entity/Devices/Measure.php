<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Repository\Devices\MeasureRepository;

#[ORM\Entity(repositoryClass: MeasureRepository::class)]
#[ORM\Table(name: 'devices.measure')]
class Measure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $timestamp = null;

    #[ORM\ManyToOne(inversedBy: 'measures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sensor $Sensor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeImmutable $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getSensor(): ?Sensor
    {
        return $this->Sensor;
    }

    public function setSensor(?Sensor $Sensor): static
    {
        $this->Sensor = $Sensor;

        return $this;
    }
}
