<?php 
namespace App\Domain\Devices\Events;

use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Events\EnumSensorEvent;

class SensorEventConfig 
{
    public function __construct(
        public readonly EnumSensorEvent $sensorEventType,
        public readonly Device $device,
        public readonly int $zone,
        public readonly int $sensorId
    ){}
}