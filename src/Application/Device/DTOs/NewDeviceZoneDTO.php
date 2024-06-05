<?php 
namespace App\Application\Device\DTOs;

class NewDeviceZoneDTO
{
    public function __construct(
        public readonly string $macAddress,
        public readonly ?string $alias = null
    ){}
}