<?php 
namespace App\Application\Device\Services;

use App\Application\Device\DTOs\NewSensorZoneDeviceDTO;
use App\Domain\Devices\Repository\IDeviceRepository;
use App\Domain\Devices\Services\CreateNewSensorService;

class AddSensorToZoneDeviceService
{
    public function __construct(
        private CreateNewSensorService $createNewSensorService,
        private IDeviceRepository $deviceRepository
    ){}

    public function execute(NewSensorZoneDeviceDTO $newSensorZoneDeviceDTO)
    {
        $this->createNewSensorService->execute($newSensorZoneDeviceDTO->sensorModelId, $newSensorZoneDeviceDTO->macAddress, $newSensorZoneDeviceDTO->zonePosition, $newSensorZoneDeviceDTO->alias);
    }
}