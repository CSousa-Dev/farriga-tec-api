<?php
namespace App\Domain\Devices\Device\Zone;

use App\Domain\Devices\Utils\Sortable;
use App\Domain\Devices\Device\Sensor\Sensor;
use App\Domain\Devices\Utils\PositionConfig;
use App\Domain\Devices\Device\Sensor\Sensors;
use App\Domain\Devices\Device\Irrigator\Irrigator;
use App\Domain\Devices\Device\Irrigator\Irrigators;

class Zone extends Sortable
{
    public function __construct(
        public  ?int    $position,
        public  readonly ?int $id = null,
        private ?string $alias = null,
        private ?Sensors $sensors = null,
        private ?Irrigators $irrigators = null
    ){}

    public function position(): int
    {
        return $this->position;
    }

    public function changeSensorPositions(PositionConfig ...$newPositions): void
    {
        $this->sensors->changePositions(...$newPositions);
    }

    public function changeIrrigatorPositions(PositionConfig ...$newPositions): void
    {
        $this->irrigators->changePositions(...$newPositions);
    }

    public function id(): int
    {
        return $this->id;
    }  
    
    public function alias(): string
    {
        return $this->alias;
    }

    public function addSensor(Sensor $sensor): int
    {
        if($this->sensors === null)
        {
            $this->sensors = new Sensors();
        }

        return $this->sensors->addSensor($sensor);
    }

    public function addIrrigator(Irrigator $irrigator): int
    {
        if($this->irrigators === null)
        {
            $this->irrigators = new Irrigators();
        }

        return $this->irrigators->addIrrigator($irrigator);
    }

    public function getSensors()
    {
        return $this->sensors;
    }

    public function getIrrigators()
    {
        return $this->irrigators;
    }
}