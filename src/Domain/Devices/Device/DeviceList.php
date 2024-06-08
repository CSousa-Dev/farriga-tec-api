<?php
namespace App\Domain\Devices\Device;

use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Utils\SortableList;

class DeviceList extends SortableList
{
    public function addDevice(Device $device)
    {
        $this->items[$device->id] = $device;
    }

    public function getDevice($id): Device
    {
        /**
         * @var Device $device
         */
        $device = $this->items[$id];
        
        return $device;
    }
}