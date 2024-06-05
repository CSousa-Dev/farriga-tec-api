<?php
namespace App\Domain\Devices\Services;

use App\Domain\Devices\Repository\IDeviceRepository;
use App\Domain\Devices\Repository\ISensorRepository;

class CreateNewSensorService
{
    public function __construct(
        private IDeviceRepository $deviceRepository,
        private ISensorRepository $sensorRepository
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
            throw new \Exception("Dispositivo não localizado");
        }

        if(!$this->sensorRepository->modelExists($modelId))
        {
            throw new \Exception("Tipo de sensor não localizado");
        }

        $sensor = $this->sensorRepository->buildSensorModel($modelId);
        $sensorPosition = $device->addSensor($sensor, $zonePosition);
        $this->deviceRepository->addNewSensor($device, $zonePosition, $sensorPosition);
    }
}