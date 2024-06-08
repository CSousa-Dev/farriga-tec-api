<?php 
namespace App\Domain\Devices\Device;

use App\Domain\Devices\Utils\Sortable;
use App\Domain\Devices\Device\Zone\Zones;
use App\Domain\Devices\Events\EventConfig;
use App\Domain\Devices\Device\Sensor\Sensor;
use App\Domain\Devices\Utils\PositionConfig;
use App\Domain\Devices\Events\DeviceEventsConfig;
use App\Domain\Devices\Device\Irrigator\Irrigator;

class Device extends Sortable
{
    /**
     * @var DeviceEventsConfig[]
     */
    private array $deviceEventsConfig;
    public function __construct(
        public  readonly string     $macAddress,
        public  readonly DeviceType $model,
        private          ?string    $alias = null,
        private          ?int       $ownerId = null,
        public  readonly ?int       $id = null,
        private          bool       $power = true,     
        public           ?int       $position = null,
        private          ?Zones     $zones = null
    ){}

    public function id(): int
    {
        return $this->id;
    }

    public function position(): int
    {
        return $this->position;
    }

    public function changePosition(int $newPosition): void
    {
        $this->position = $newPosition;
    }

    public function changeSensorPositions(int $zoneId, PositionConfig ...$newPositions): void
    {
        $this->zones->changeSensorPositions($zoneId, ...$newPositions);
    }

    public function changeIrrigatorPositions(int $zoneId, PositionConfig ...$newPositions): void
    {
        $this->zones->changeIrrigatorPositions($zoneId, ...$newPositions);
    }


    public function alias(): ?string
    {
        return $this->alias;
    }

    public function changeAlias(string $newAlias): void
    {
        $this->alias = $newAlias;
    }

    public function power(): bool
    {
        return $this->power;
    }

    public function changePower(bool $newPower): void
    {
        $this->power = $newPower;
    }   

    public function createZone(string $alias = null)
    {
        if($this->zones === null)
            $this->zones = new Zones();

        return $this->zones->createZone($alias);
    }

    public function addOwner(int $userId): void
    {
        if($this->ownerId === null)
            $this->ownerId = $userId;

        throw new \DomainException("Dispositivo já está vinculado a um usuário.");
    }

    public function zones(): Zones
    {
        return $this->zones;
    }

    public function addSensor(
        Sensor $sensor,
        int $zonePosition
    ): int
    {
        return $this->zones->addSensor(
            $sensor,
            $zonePosition
        );
    }

    public function addIrrigator(
        Irrigator $irrigator,
        int $zonePosition
    ): int
    {
        return $this->zones->addIrrigator(
            $irrigator,
            $zonePosition
        );
    }

    public function addCondifguredEvents(EventConfig ...$deviceEventsConfig): void
    {
        $this->deviceEventsConfig = $deviceEventsConfig;
    }

    public function configuredEvents(): array
    {
        return $this->deviceEventsConfig;
    }
}