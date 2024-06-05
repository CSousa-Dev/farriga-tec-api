<?php 
namespace App\Domain\Devices\Device;

class DeviceType
{
    public function __construct(
        public readonly int $id,
        public readonly bool $useBluetooth,
        public readonly bool $useWifiConnection,
        public readonly bool $canPowerControll,
        public readonly bool $canManualControll,
        public readonly string $model
    ){}
}