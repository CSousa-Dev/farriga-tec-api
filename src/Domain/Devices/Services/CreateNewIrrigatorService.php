<?php
namespace App\Domain\Devices\Services;

use App\Domain\Devices\Repository\IDeviceRepository;
use App\Domain\Devices\Repository\IIrrigatorRepository;

class CreateNewIrrigatorService
{
    public function __construct(
        private IDeviceRepository $deviceRepository,
        private IIrrigatorRepository $irrigatorRepository
    ){}

    public function execute(
        int $modelId,
        string $deviceMacAddress,
        int $zonePosition,
        ?string $alias
    )
    {
        $device = $this->deviceRepository->findDeviceByMacAddress($deviceMacAddress);
        
        if($device === null)
        {
            throw new \DomainException("Dispositivo não localizado");
        }

        if(!$this->irrigatorRepository->modelExists($modelId))
        {
            throw new \DomainException("Tipo de irrigador não localizado");
        }

        $sensor = $this->irrigatorRepository->buildIrrigatorModel($modelId);
        $irrigatorPosition = $device->addIrrigator($sensor, $zonePosition);
        $this->deviceRepository->addNewIrrigator($device, $zonePosition, $irrigatorPosition);
    }
}