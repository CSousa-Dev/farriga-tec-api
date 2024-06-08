<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Infra\Doctrine\Entity\Devices\Device;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Entity\Devices\DeviceEvent;
use App\Infra\Doctrine\Repository\Devices\DeviceTypeRepository;

#[ORM\Entity(repositoryClass: DeviceTypeRepository::class)]
#[ORM\Table(name: 'devices.device_type')]
class DeviceType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $useBluetooth = null;

    #[ORM\Column]
    private ?bool $useWifiConnection = null;

    #[ORM\Column]
    private ?bool $canPowerControll = null;

    #[ORM\Column]
    private ?bool $canManualControll = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    /**
     * @var Collection<int, Device>
     */
    #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'deviceType')]
    private Collection $Devices;

    /**
     * @var Collection<int, DeviceEvent>
     */
    #[ORM\OneToMany(targetEntity: DeviceEvent::class, mappedBy: 'device', orphanRemoval: true, cascade: ['persist'])]
    private Collection $deviceEvents;

    public function __construct()
    {
        $this->Devices = new ArrayCollection();
        $this->deviceEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isUseBluetooth(): ?bool
    {
        return $this->useBluetooth;
    }

    public function setUseBluetooth(bool $useBluetooth): static
    {
        $this->useBluetooth = $useBluetooth;

        return $this;
    }

    public function isUseWifiConnection(): ?bool
    {
        return $this->useWifiConnection;
    }

    public function setUseWifiConnection(bool $useWifiConnection): static
    {
        $this->useWifiConnection = $useWifiConnection;

        return $this;
    }

    public function isCanPowerControll(): ?bool
    {
        return $this->canPowerControll;
    }

    public function setCanPowerControll(bool $canPowerControll): static
    {
        $this->canPowerControll = $canPowerControll;

        return $this;
    }

    public function canManualControll(): ?bool
    {
        return $this->canManualControll;
    }

    public function setCanManualControll(bool $canManualControll): static
    {
        $this->canManualControll = $canManualControll;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Collection<int, Device>
     */
    public function getDevices(): Collection
    {
        return $this->Devices;
    }

    public function addDevice(Device $device): static
    {
        if (!$this->Devices->contains($device)) {
            $this->Devices->add($device);
            $device->setDeviceType($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): static
    {
        if ($this->Devices->removeElement($device)) {
            // set the owning side to null (unless already changed)
            if ($device->getDeviceType() === $this) {
                $device->setDeviceType(null);
            }
        }

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
            $deviceEvent->setDevice($this);
        }

        return $this;
    }

    public function removeDeviceEvent(DeviceEvent $deviceEvent): static
    {
        if ($this->deviceEvents->removeElement($deviceEvent)) {
            // set the owning side to null (unless already changed)
            if ($deviceEvent->getDevice() === $this) {
                $deviceEvent->setDevice(null);
            }
        }

        return $this;
    }
}
