<?php 
namespace App\Application\Device\Services;

use App\Domain\Devices\Repository\IDeviceRepository;
use App\Application\Device\DTOs\NewSensorZoneDeviceDTO;
use App\Application\Device\DTOs\NewIrrigatorZoneDeviceDTO;
use App\Domain\Devices\Services\CreateNewIrrigatorService;

class AddIrrigatorToZoneDeviceService
{
    public function __construct(
        private CreateNewIrrigatorService $createNewSensorService,
        private IDeviceRepository $deviceRepository
    ){}

    public function execute(NewIrrigatorZoneDeviceDTO $newSensorZoneDeviceDTO)
    {
        $this->createNewSensorService->execute($newSensorZoneDeviceDTO->irrigatorModelId, $newSensorZoneDeviceDTO->macAddress, $newSensorZoneDeviceDTO->zonePosition, $newSensorZoneDeviceDTO->alias);
    }
}