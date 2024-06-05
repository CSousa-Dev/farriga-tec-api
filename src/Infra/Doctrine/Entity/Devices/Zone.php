<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Repository\Devices\ZoneRepository;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ORM\Table(name: 'devices.zone')]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(length: 255)]
    private ?string $alias = null;

    /**
     * @var Collection<int, Sensor>
     */
    #[ORM\OneToMany(targetEntity: Sensor::class, mappedBy: 'zone', orphanRemoval: true)]
    private Collection $sensors;

    /**
     * @var Collection<int, Irrigator>
     */
    #[ORM\OneToMany(targetEntity: Irrigator::class, mappedBy: 'zone', orphanRemoval: true)]
    private Collection $irrigators;

    #[ORM\ManyToOne(inversedBy: 'zones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Device $Device = null;

    public function __construct()
    {
        $this->sensors = new ArrayCollection();
        $this->irrigators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return Collection<int, Sensor>
     */
    public function getSensors(): Collection
    {
        return $this->sensors;
    }

    public function addSensor(Sensor $sensor): static
    {
        if (!$this->sensors->contains($sensor)) {
            $this->sensors->add($sensor);
            $sensor->setZone($this);
        }

        return $this;
    }

    public function removeSensor(Sensor $sensor): static
    {
        if ($this->sensors->removeElement($sensor)) {
            // set the owning side to null (unless already changed)
            if ($sensor->getZone() === $this) {
                $sensor->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Irrigator>
     */
    public function getIrrigators(): Collection
    {
        return $this->irrigators;
    }

    public function addIrrgator(Irrigator $irrgator): static
    {
        if (!$this->irrigators->contains($irrgator)) {
            $this->irrigators->add($irrgator);
            $irrgator->setZone($this);
        }

        return $this;
    }

    public function removeIrrigator(Irrigator $irrgator): static
    {
        if ($this->irrigators->removeElement($irrgator)) {
            // set the owning side to null (unless already changed)
            if ($irrgator->getZone() === $this) {
                $irrgator->setZone(null);
            }
        }

        return $this;
    }

    public function getDevice(): ?Device
    {
        return $this->Device;
    }

    public function setDevice(?Device $Device): static
    {
        $this->Device = $Device;

        return $this;
    }
}
