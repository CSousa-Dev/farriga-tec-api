<?php 
namespace App\Application\Device\DTOs;

class NewSensorZoneDeviceDTO
{
    public function __construct(
        public string $macAddress,
        public ?string $alias,
        public int $zonePosition,
        public int $sensorModelId
    ){}
}