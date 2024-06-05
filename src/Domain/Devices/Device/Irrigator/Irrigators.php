<?php 
namespace App\Domain\Devices\Device\Irrigator;

use App\Domain\Devices\SortableList;
use App\Domain\Devices\Irrigator\Irrigator;

class Irrigators extends SortableList
{
    public function addIrrigators(Irrigator $irrigator)
    {
        $this->items[$irrigator->id] = $irrigator;
    }
}