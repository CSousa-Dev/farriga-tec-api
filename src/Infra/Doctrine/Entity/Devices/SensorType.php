<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Entity\Devices\EventConfig;
use App\Infra\Doctrine\Entity\Devices\SensorEvent;
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
     * @var Collection<int, SensorEvent>
     */
    #[ORM\OneToMany(targetEntity: SensorEvent::class, mappedBy: 'sensorType', orphanRemoval: true, cascade: ['persist'])]
    private Collection $sensorEvents;



    public function __construct()
    {
        $this->sensorEvents = new ArrayCollection();
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
     * @return Collection<int, SensorEvent>
     */
    public function getSensorEvents(): Collection
    {
        return $this->sensorEvents;
    }

    public function addSensorEvent(SensorEvent $sensorEvent): static
    {
        if (!$this->sensorEvents->contains($sensorEvent)) {
            $this->sensorEvents->add($sensorEvent);
            $sensorEvent->setSensorType($this);
        }

        return $this;
    }

    public function removeSensorEvent(SensorEvent $sensorEvent): static
    {
        if ($this->sensorEvents->removeElement($sensorEvent)) {
            // set the owning side to null (unless already changed)
            if ($sensorEvent->getSensorType() === $this) {
                $sensorEvent->setSensorType(null);
            }
        }

        return $this;
    }

}
