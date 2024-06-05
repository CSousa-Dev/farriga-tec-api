<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Repository\Devices\IrrigatorTypeRepository;

#[ORM\Entity(repositoryClass: IrrigatorTypeRepository::class)]
#[ORM\Table(name: 'devices.irrigator_type')]
class IrrigatorType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $canManualControlIrrigation = null;

    #[ORM\Column]
    private ?bool $canChangeWateringTime = null;

    #[ORM\Column]
    private ?bool $canChangeCheckInterval = null;

    #[ORM\Column]
    private ?bool $canTurnOnTurnOff = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Irrigator>
     */
    #[ORM\OneToMany(targetEntity: Irrigator::class, mappedBy: 'irrigatorType', cascade: ['persist'])]
    private Collection $irrigators;

    /**
     * @var Collection<int, EventType>
     */
    #[ORM\ManyToMany(targetEntity: EventType::class, mappedBy: 'irrigatorEvents', cascade: ['persist'])]
    private Collection $eventConfig;

    public function __construct()
    {
        $this->irrigators = new ArrayCollection();
        $this->eventConfig = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function canManualControlIrrigation(): ?bool
    {
        return $this->canManualControlIrrigation;
    }

    public function setCanManualControlIrrigation(bool $canManualControlIrrigation): static
    {
        $this->canManualControlIrrigation = $canManualControlIrrigation;

        return $this;
    }

    public function canChangeWateringTime(): ?bool
    {
        return $this->canChangeWateringTime;
    }

    public function setCanChangeWateringTime(bool $canChangeWateringTime): static
    {
        $this->canChangeWateringTime = $canChangeWateringTime;

        return $this;
    }

    public function canChangeCheckInterval(): ?bool
    {
        return $this->canChangeCheckInterval;
    }

    public function setCanChangeCheckInterval(bool $canChangeCheckInterval): static
    {
        $this->canChangeCheckInterval = $canChangeCheckInterval;

        return $this;
    }

    public function canTurnOnTurnOff(): ?bool
    {
        return $this->canTurnOnTurnOff;
    }

    public function setCanTurnOnTurnOff(bool $canTurnOnTurnOff): static
    {
        $this->canTurnOnTurnOff = $canTurnOnTurnOff;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Irrigator>
     */
    public function getIrrigators(): Collection
    {
        return $this->irrigators;
    }

    public function addIrrigator(Irrigator $irrigator): static
    {
        if (!$this->irrigators->contains($irrigator)) {
            $this->irrigators->add($irrigator);
            $irrigator->setIrrigatorType($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, EventType>
     */
    public function getEventConfig(): Collection
    {
        return $this->eventConfig;
    }

    public function addEventConfig(EventType $eventConfig): static
    {
        if (!$this->eventConfig->contains($eventConfig)) {
            $this->eventConfig->add($eventConfig);
        }

        return $this;
    }

    public function removeEventConfig(EventType $eventConfig): static
    {
        $this->eventConfig->removeElement($eventConfig);

        return $this;
    }
}
