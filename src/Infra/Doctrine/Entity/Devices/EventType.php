<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Entity\Devices\DeviceType;
use App\Infra\Doctrine\Entity\Devices\IrrigatorType;
use App\Infra\Doctrine\Repository\Devices\EventTypeRepository;

#[ORM\Entity(repositoryClass: EventTypeRepository::class)]
#[ORM\Table(name: 'devices.event_type')]
class EventType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $canListen = null;

    #[ORM\Column]
    private ?bool $canEmit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $listenKey = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emitKey = null;


    /**
     * @var Collection<int, SensorType>
     */
    #[ORM\ManyToMany(targetEntity: SensorType::class, inversedBy: 'eventConfig', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'devices.sensor_event')]
    private Collection $sensorEvents;

    /**
     * @var Collection<int, IrrigatorType>
     */
    #[ORM\ManyToMany(targetEntity: IrrigatorType::class, inversedBy: 'eventConfig', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'devices.irrigator_event')]
    private Collection $irrigatorEvents;

    /**
     * @var Collection<int, DeviceType>
     */
    #[ORM\ManyToMany(targetEntity: DeviceType::class, inversedBy: 'eventConfig', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'devices.device_event')]
    private Collection $deviceEvents;

    public function __construct()
    {
        $this->sensorEvents = new ArrayCollection();
        $this->irrigatorEvents = new ArrayCollection();
        $this->deviceEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setEmitKey(string $emitKey): static
    {
        $this->emitKey = $emitKey;

        return $this;
    }

    public function getEmitKey(): ?string
    {
        return $this->emitKey;
    }

    public function canListen(): ?bool
    {
        return $this->canListen;
    }

    public function setCanListen(bool $canListen): static
    {
        $this->canListen = $canListen;

        return $this;
    }

    public function isCanEmit(): ?bool
    {
        return $this->canEmit;
    }

    public function setCanEmit(bool $canEmit): static
    {
        $this->canEmit = $canEmit;

        return $this;
    }

    public function getListenKey(): ?string
    {
        return $this->listenKey;
    }

    public function setListenKey(string $listenKey): static
    {
        $this->listenKey = $listenKey;

        return $this;
    }


    /**
     * @return Collection<int, SensorType>
     */
    public function getSensor(): Collection
    {
        return $this->sensorEvents;
    }

    public function addSensor(SensorType $sensor): static
    {
        if (!$this->sensorEvents->contains($sensor)) {
            $this->sensorEvents->add($sensor);
        }

        return $this;
    }

    public function removeSensor(SensorType $sensor): static
    {
        $this->sensorEvents->removeElement($sensor);

        return $this;
    }

    /**
     * @return Collection<int, Irrigator>
     */
    public function getIrrigatorType(): Collection
    {
        return $this->irrigatorEvents;
    }

    public function addIrrigatorType(IrrigatorType $irrigatorType): static
    {
        if (!$this->irrigatorEvents->contains($irrigatorType)) {
            $this->irrigatorEvents->add($irrigatorType);
        }

        return $this;
    }

    public function removeIrrigatorType(IrrigatorType $irrigatorType): static
    {
        $this->irrigatorEvents->removeElement($irrigatorType);

        return $this;
    }

    /**
     * @return Collection<int, DeviceType>
     */
    public function getDeviceTypes(): Collection
    {
        return $this->deviceEvents;
    }

    public function addDeviceType(DeviceType $deviceType): static
    {
        if (!$this->deviceEvents->contains($deviceType)) {
            $this->deviceEvents->add($deviceType);
            $deviceType->addEventConfig($this);
        }

        return $this;
    }

    public function removeDeviceType(DeviceType $deviceType): static
    {
        if ($this->deviceEvents->removeElement($deviceType)) {
            $deviceType->removeEventConfig($this);
        }

        return $this;
    }
}
