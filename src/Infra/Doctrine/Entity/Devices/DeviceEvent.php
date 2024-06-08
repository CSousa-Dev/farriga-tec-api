<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Entity\Devices\DeviceType;
use App\Infra\Doctrine\Entity\Devices\EventConfig;
use App\Infra\Doctrine\Repository\Devices\DeviceEventRepository;

#[ORM\Entity(repositoryClass: DeviceEventRepository::class)]
#[ORM\Table(name: 'devices.device_event')]
class DeviceEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'deviceEvents', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?EventConfig $event = null;

    #[ORM\ManyToOne(inversedBy: 'deviceEvents', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?DeviceType $device = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDevice(): ?DeviceType
    {
        return $this->device;
    }

    public function setDevice(?DeviceType $device): static
    {
        $this->device = $device;

        return $this;
    }
}
