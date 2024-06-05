<?php
namespace App\Domain\Devices\Device\Zone;

use App\Domain\Devices\SortableList;
use App\Domain\Devices\Device\Zone\Zone;
use App\Domain\Devices\Utils\PositionConfig;

class Zones extends SortableList
{
    public function createZone(string $alias = null): int
    {
        if($alias === null)
        {
            $alias = "Zone " . count($this->items);
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
        $this->items[$zone->position()] = $zone;
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
}