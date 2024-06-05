<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Repository\Devices\SensorTypeRepository;

#[ORM\Entity(repositoryClass: SensorTypeRepository::class)]
#[ORM\Table(name: 'devices.sensor_type')]
class SensorType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column]
    private ?bool $canControllStartStop = null;

    #[ORM\Column]
    private ?bool $canChangeTreshold = null;


    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $unit = null;

    /**
     * @var Collection<int, EventType>
     */
    #[ORM\ManyToMany(targetEntity: EventType::class, mappedBy: 'sensorEvents', cascade: ['persist'])]
    private Collection $condifguredEvents;

    public function __construct()
    {
        $this->condifguredEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function isCanControllStartStop(): ?bool
    {
        return $this->canControllStartStop;
    }

    public function setCanControllStartStop(bool $canControllStartStop): static
    {
        $this->canControllStartStop = $canControllStartStop;

        return $this;
    }

    public function isCanChangeTreshold(): ?bool
    {
        return $this->canChangeTreshold;
    }

    public function setCanChangeTreshold(bool $canChangeTreshold): static
    {
        $this->canChangeTreshold = $canChangeTreshold;

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
     * @return Collection<int, EventType>
     */
    public function getCondifguredEvents(): Collection
    {
        return $this->condifguredEvents;
    }

    public function addCondifguredEvent(EventType $condifguredEvent): static
    {
        if (!$this->condifguredEvents->contains($condifguredEvent)) {
            $this->condifguredEvents->add($condifguredEvent);
        }

        return $this;
    }

    public function removeCondifguredEvent(EventType $condifguredEvent): static
    {
        $this->condifguredEvents->removeElement($condifguredEvent);

        return $this;
    }
}
