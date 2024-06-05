<?php 
namespace App\Application\Device\Services;

use App\Application\Device\DTOs\NewDeviceZoneDTO;
use App\Domain\Devices\Repository\IDeviceRepository;
use App\Domain\Devices\Services\CreateNewZoneService;

class AddZoneToDeviceService 
{
    public function __construct(
        private IDeviceRepository $deviceRepository,
        private CreateNewZoneService $createNewZoneService
    )
    {}

    public function execute(
        NewDeviceZoneDTO $newZoneDTO
    )
    {
        $this->createNewZoneService->execute($newZoneDTO->macAddress, $newZoneDTO->alias);
        return $this->deviceRepository->findDeviceByMacAddress($newZoneDTO->macAddress);
    }
}