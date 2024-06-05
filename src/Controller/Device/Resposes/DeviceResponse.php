<?php 
namespace App\Controller\Device\Resposes;

use App\Domain\Devices\Device\Device;

class DeviceResponse
{
    public function __construct(
        public readonly Device $device
    ){}

    public function toArray()
    {
        return [
            "id" => $this->device->id,
            "macAddress" => $this->device->macAddress,
            "alias" => $this->device->alias(),
            "zones" => $this->parseZones(),
        ];
    }

    private function parseZones()
    {
        $zones = [];
        foreach ($this->device->zones() as $zone) {
            $zones[] = [
                "id" => $zone->id(),
                "alias" => $zone->alias(),
                "position" => $zone->position()
            ];
        }

        return $zones;
    }
}