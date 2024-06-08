<?php

namespace App\Infra\Doctrine\Entity\Devices;

use App\Entity\DeviceEvent;
use Doctrine\ORM\Mapping as ORM;
use App\Infra\Doctrine\Entity\Account\User;
use App\Infra\Doctrine\Entity\Devices\Zone;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Entity\Devices\DeviceType;
use App\Infra\Doctrine\Repository\Devices\DeviceRepository;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
#[ORM\Table(name: 'devices.device')]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'devices')]
    private ?User $owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alias = null;

    #[ORM\Column(nullable: false)]
    private ?string $macAddress = null;

    #[ORM\Column]
    private ?bool $power = null;

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    /**
     * @var Collection<int, Zone>
     */
    #[ORM\OneToMany(targetEntity: Zone::class, mappedBy: 'Device', orphanRemoval: true, cascade: ['persist'])]
    private Collection $zones;


    #[ORM\ManyToOne(inversedBy: 'Devices', cascade: ['persist'])]
    private ?DeviceType $deviceType = null;

    public function __construct()
    {
        $this->zones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    public function isPower(): ?bool
    {
        return $this->power;
    }

    public function setPower(bool $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getMacAddress(): ?string
    {
        return $this->macAddress;
    }

    public function setMacAddress(string $macAddress): static
    {
        $this->macAddress = $macAddress;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, Zone>
     */
    public function getZones(): Collection
    {
        return $this->zones;
    }

    public function addZone(Zone $zone): static
    {
        if (!$this->zones->contains($zone)) {
            $this->zones->add($zone);
            $zone->setDevice($this);
        }

        return $this;
    }

    public function removeZone(Zone $zone): static
    {
        if ($this->zones->removeElement($zone)) {
            // set the owning side to null (unless already changed)
            if ($zone->getDevice() === $this) {
                $zone->setDevice(null);
            }
        }

        return $this;
    }

    public function getDeviceType(): ?DeviceType
    {
        return $this->deviceType;
    }

    public function setDeviceType(?DeviceType $deviceType): static
    {
        $this->deviceType = $deviceType;

        return $this;
    }
}
