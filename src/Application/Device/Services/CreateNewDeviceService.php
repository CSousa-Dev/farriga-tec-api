<?php 
namespace App\Application\Device\Services;

use App\Domain\Devices\Device\Device;
use App\Application\Device\DTOs\NewDeviceDTO;
use App\Domain\Devices\Repository\IDeviceRepository;
use App\Domain\Devices\Services\CreateDeviceService;

class CreateNewDeviceService
{
    public function __construct(
        private CreateDeviceService $createDeviceService,
        private IDeviceRepository $deviceRepository
    ){}

    public function execute(NewDeviceDTO $newDeviceDTO): Device
    {
        $this->createDeviceService->execute(
            $newDeviceDTO->modelId,
            $newDeviceDTO->macAddress
        );

        return $this->deviceRepository->findDeviceByMacAddress($newDeviceDTO->macAddress);
    }
}