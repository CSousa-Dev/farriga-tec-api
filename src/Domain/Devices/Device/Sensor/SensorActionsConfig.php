<?php
namespace App\Domain\Devices\Device\Sensor;

use App\Domain\Devices\Device\Sensor\TresholdType;

class SensorActionsConfig 
{
    public function __construct(
        public readonly bool $canControllStartStop,
        public readonly bool $canChangeTreshold,
        public readonly TresholdType $tresholdType
    )
    {}
}