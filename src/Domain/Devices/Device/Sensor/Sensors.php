<?php 
namespace App\Domain\Devices\Device\Sensor;

use App\Domain\Devices\SortableList;
use App\Domain\Devices\Device\Sensor\Sensor;

class Sensors extends SortableList
{
    /**
     * @var Sensor[]
     */
    public function addSensor(Sensor $sensor): int
    {
        if($sensor->position === null) {
            $sensor->position = $this->nextPosition();
        }

        $this->items[$sensor->position()] = $sensor;
        return $sensor->position();
    }

    public function getSensor($id): Sensor
    {
        return $this->items[$id];
    }
}