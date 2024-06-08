<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Entity\Devices\EventConfig;
use App\Infra\Doctrine\Entity\Devices\IrrigatorType;
use App\Infra\Doctrine\Repository\Devices\IrrigatorEventRepository;

#[ORM\Entity(repositoryClass: IrrigatorEventRepository::class)]
#[ORM\Table(name: 'devices.irrigator_event')]
class IrrigatorEvent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'irrigatorEvents', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?IrrigatorType $irrigator = null;

    #[ORM\ManyToOne(inversedBy: 'irrigatorEvents', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?EventConfig $event = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIrrigator(): ?IrrigatorType
    {
        return $this->irrigator;
    }

    public function setIrrigator(?IrrigatorType $irrigator): static
    {
        $this->irrigator = $irrigator;

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
