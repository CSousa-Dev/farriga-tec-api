<?php 
namespace App\Domain\Devices\Device\Irrigator;

use App\Domain\Devices\SortableList;
use App\Domain\Devices\Device\Irrigator\Irrigator;

class Irrigators extends SortableList
{
    public function addIrrigator(Irrigator $irrigator)
    {
        if($irrigator->position === null) {
            $irrigator->position = $this->nextPosition();
        }

        $this->items[$irrigator->position()] = $irrigator;

        return $irrigator->position();
    }

    public function getIrrigator($position): Irrigator
    {
        return $this->items[$position];
    }


}