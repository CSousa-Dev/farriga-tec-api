<?php
namespace App\Application\Device\Services;

use App\Domain\Devices\Repository\IDeviceRepository;

class ListAllUserDevicesService
{
    public function __construct(
        private IDeviceRepository $deviceRepository
    ){}

    public function execute(string $userEmail)
    {
        $deviceList = $this->deviceRepository->findAllDevicesByUserEmail($userEmail);

        return $deviceList;
    }
}