<?php 
namespace App\Domain\Devices\Services;

use App\Domain\Devices\Repository\IDeviceRepository;

class CreateNewZoneService 
{
    public function __construct(
        private IDeviceRepository $deviceRepository
    )
    {}

    public function execute(
        string $macAddress,
        string $alias = null
    )
    {
        $device = $this->deviceRepository->findDeviceByMacAddress($macAddress);
        
        if($device === null)
        {
            throw new \Exception("Dispositivo não localizado");
        }

        $newZonePosition = $device->createZone($alias);
        $this->deviceRepository->addNewZone($device, $newZonePosition);
    }
}