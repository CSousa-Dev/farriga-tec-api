<?php
namespace App\Domain\Devices\Device\Zone;

use App\Domain\Devices\Device\Zone\Zone;
use App\Domain\Devices\Utils\SortableList;
use App\Domain\Devices\Device\Sensor\Sensor;
use App\Domain\Devices\Utils\PositionConfig;
use App\Domain\Devices\Device\Irrigator\Irrigator;

class Zones extends SortableList
{
    /**
     * @var Zone[]
     */
    protected array $items = []; 

    public function createZone(string $alias = null): int
    {
        if($alias === null)
        {
            $alias = "Zone " . count($this->items) + 1;
        }

        $zone = new Zone(position: $this->nextPosition(), alias: $alias);
        $this->addZone($zone);

        return $zone->position();
    }

    /**
     * @var Zone[] $items
     */
    public function addZone(Zone $zone)
    {
        if($this->checkNewAliasAlreadyExists($zone->alias()))
        {
            throw new \DomainException('Não são permitidas zonas com o mesmo nome de identificação, informe um nome diferente.');
        }

        $this->items[$zone->position()] = $zone;
    }

    private function checkNewAliasAlreadyExists(string $alias): bool
    {
        /**
         * @var Zone $zone
         */
        foreach($this->items as $zone)
        {
            if($zone->alias() === $alias)
            {
                return true;
            }
        }

        return false;
    }

    public function getZone($position): Zone
    {
        /**
         * @var Zone $zone
         */
        $zone = $this->items[$position];
        return $zone;
    }

    public function changeSensorPositions(int $zoneId, PositionConfig ...$positionConfig)
    {
        $zone = $this->getZone($zoneId);
        $zone->changeSensorPositions(...$positionConfig);
        $this->items[$zoneId] = $zone;
    }

    public function changeIrrigatorPositions(int $zonePosition, PositionConfig ...$positionConfig)
    {
        $zone = $this->getZone($zonePosition);
        $zone->changeIrrigatorPositions(...$positionConfig);
        $this->items[$zone->position()] = $zone;
    }

    public function addSensor(
        Sensor $sensor,
        int $zonePosition
    ): int
    {
        if(!isset($this->items[$zonePosition]))
        {
            throw new \DomainException("Zona não localizada. Informe uma zona válida para adicionar um sensor.");
        }

        return $this->items[$zonePosition]->addSensor($sensor);
    }

    public function addIrrigator(
        Irrigator $sensor,
        int $zonePosition
    ): int
    {
        if(!isset($this->items[$zonePosition]))
        {
            throw new \DomainException("Zona não localizada. Informe uma zona válida para adicionar um irrigador.");
        }

        return $this->items[$zonePosition]->addIrrigator($sensor);
    }
}