<?php

namespace App\Infra\Doctrine\Entity\Devices;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Infra\Doctrine\Repository\Devices\SensorRepository;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
#[ORM\Table(name: 'devices.sensor')]
class Sensor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alias = null;

    #[ORM\ManyToOne(inversedBy: 'sensors')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Zone $zone = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?SensorType $SensorType = null;

    /**
     * @var Collection<int, Measure>
     */
    #[ORM\OneToMany(targetEntity: Measure::class, mappedBy: 'Sensor', orphanRemoval: true)]
    private Collection $measures;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Treshold $treshold = null;

    public function __construct()
    {
        $this->measures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): static
    {
        $this->zone = $zone;

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

    public function getSensorType(): ?SensorType
    {
        return $this->SensorType;
    }

    public function setSensorType(?SensorType $SensorType): static
    {
        $this->SensorType = $SensorType;

        return $this;
    }

    /**
     * @return Collection<int, Measure>
     */
    public function getMeasures(): Collection
    {
        return $this->measures;
    }

    public function addMeasure(Measure $measure): static
    {
        if (!$this->measures->contains($measure)) {
            $this->measures->add($measure);
            $measure->setSensor($this);
        }

        return $this;
    }

    public function removeMeasure(Measure $measure): static
    {
        if ($this->measures->removeElement($measure)) {
            // set the owning side to null (unless already changed)
            if ($measure->getSensor() === $this) {
                $measure->setSensor(null);
            }
        }

        return $this;
    }

    public function getTreshold(): ?Treshold
    {
        return $this->treshold;
    }

    public function setTreshold(?Treshold $treshold): static
    {
        $this->treshold = $treshold;

        return $this;
    }
}
