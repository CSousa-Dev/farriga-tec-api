<?php
namespace App\Domain\Devices\Events;

use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Events\EnumIrrigatorEvent;

class IrrigatorEventType 
{
    public function __construct(
        public readonly EnumIrrigatorEvent $irrigationEventType,
        public readonly Device $device,
        public readonly int $zone,
        public readonly int $irrigatorId
    ){}
}