<?php 
namespace App\Domain\Devices\Device\Sensor;

use App\Domain\Devices\SortableList;
use App\Domain\Devices\Device\Sensor\Sensor;

class Sensors extends SortableList
{
    /**
     * @var Sensor[]
     */
    public function addSensor(Sensor $sensor)
    {
        $this->items[$sensor->id] = $sensor;
    }

    public function getSensor($id): Sensor
    {
        return $this->items[$id];
    }
}