<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Entity\Devices\SensorType;
use App\Infra\Doctrine\Entity\Devices\EventConfig;
use App\Infra\Doctrine\Repository\Devices\SensorEventRepository;

#[ORM\Entity(repositoryClass: SensorEventRepository::class)]
#[ORM\Table(name: 'devices.sensor_event')]
class SensorEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sensorEvents', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?SensorType $sensorType = null;

    #[ORM\ManyToOne(inversedBy: 'sensorEvents', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?EventConfig $event = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSensorType(): ?SensorType
    {
        return $this->sensorType;
    }

    public function setSensorType(?SensorType $sensorType): static
    {
        $this->sensorType = $sensorType;

        return $this;
    }

    public function getEvent(): ?EventConfig
    {
        return $this->event;
    }

    public function setEvent(?EventConfig $event): static
    {
        $this->event = $event;

        return $this;
    }

}
