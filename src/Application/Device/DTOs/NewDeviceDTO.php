<?php 
namespace App\Application\Device\DTOs;

class NewDeviceDTO
{
    public function __construct(
        public readonly string $macAddress,
        public readonly int $modelId
    )
    {}
}