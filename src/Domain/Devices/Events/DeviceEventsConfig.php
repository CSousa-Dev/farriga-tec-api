<?php
namespace App\Domain\Devices\Events;

use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Events\EnumDeviceEvents;

class DeviceEventsConfig 
{
    public function __construct(
        public readonly EnumDeviceEvents $deviceEventType,
        public readonly Device $device
    ){}
}