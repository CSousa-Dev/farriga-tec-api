<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Entity\Devices\DeviceEvent;
use App\Infra\Doctrine\Entity\Devices\SensorEvent;
use App\Infra\Doctrine\Entity\Devices\IrrigatorEvent;
use App\Infra\Doctrine\Repository\Devices\EventConfigRepository;

#[ORM\Entity(repositoryClass: EventConfigRepository::class)]
#[ORM\Table(name: 'devices.event_config')]
class EventConfig
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
     * @var Collection<int, DeviceEvent>
     */
    #[ORM\OneToMany(targetEntity: DeviceEvent::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $deviceEvents;

    /**
     * @var Collection<int, IrrigatorEvent>
     */
    #[ORM\OneToMany(targetEntity: IrrigatorEvent::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $irrigatorEvents;

    /**
     * @var Collection<int, SensorEvent>
     */
    #[ORM\OneToMany(targetEntity: SensorEvent::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $sensorEvents;

    public function __construct()
    {
        $this->deviceEvents = new ArrayCollection();
        $this->irrigatorEvents = new ArrayCollection();
        $this->sensorEvents = new ArrayCollection();
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

    public function isCanListen(): ?bool
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

    public function setListenKey(?string $listenKey): static
    {
        $this->listenKey = $listenKey;

        return $this;
    }

    public function getEmitKey(): ?string
    {
        return $this->emitKey;
    }

    public function setEmitKey(?string $emitKey): static
    {
        $this->emitKey = $emitKey;

        return $this;
    }

    /**
     * @return Collection<int, DeviceEvent>
     */
    public function getDeviceEvents(): Collection
    {
        return $this->deviceEvents;
    }

    public function addDeviceEvent(DeviceEvent $deviceEvent): static
    {
        if (!$this->deviceEvents->contains($deviceEvent)) {
            $this->deviceEvents->add($deviceEvent);
            $deviceEvent->setEvent($this);
        }

        return $this;
    }

    public function removeDeviceEvent(DeviceEvent $deviceEvent): static
    {
        if ($this->deviceEvents->removeElement($deviceEvent)) {
            // set the owning side to null (unless already changed)
            if ($deviceEvent->getEvent() === $this) {
                $deviceEvent->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, IrrigatorEvent>
     */
    public function getIrrigatorEvents(): Collection
    {
        return $this->irrigatorEvents;
    }

    public function addIrrigatorEvent(IrrigatorEvent $irrigatorEvent): static
    {
        if (!$this->irrigatorEvents->contains($irrigatorEvent)) {
            $this->irrigatorEvents->add($irrigatorEvent);
            $irrigatorEvent->setEvent($this);
        }

        return $this;
    }

    public function removeIrrigatorEvent(IrrigatorEvent $irrigatorEvent): static
    {
        if ($this->irrigatorEvents->removeElement($irrigatorEvent)) {
            // set the owning side to null (unless already changed)
            if ($irrigatorEvent->getEvent() === $this) {
                $irrigatorEvent->setEvent(null);
            }
        }

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
            $sensorEvent->setEvent($this);
        }

        return $this;
    }

    public function removeSensorEvent(SensorEvent $sensorEvent): static
    {
        if ($this->sensorEvents->removeElement($sensorEvent)) {
            // set the owning side to null (unless already changed)
            if ($sensorEvent->getEvent() === $this) {
                $sensorEvent->setEvent(null);
            }
        }

        return $this;
    }
}
