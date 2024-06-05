<?php 
namespace App\Domain\Devices\Services;

use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Repository\IDeviceRepository;

class CreateDeviceService
{

    public function __construct(
        private IDeviceRepository $deviceRepository
    ) {}

    public function execute($modelId, $macAddress): void
    {
        $macAddressIsInUse = $this->deviceRepository->isMacAddressInUse($macAddress);

        if ($macAddressIsInUse) {
            throw new \DomainException('Este endereço MAC já está em uso.');
        }

        $modelExists = $this->deviceRepository->modelExists($modelId);

        if (!$modelExists) {
            throw new \DomainException('Modelo não localizado.');
        }

        $model = $this->deviceRepository->findModel($modelId);

        $device = new Device(
            $macAddress,
            $model
        );

        $this->deviceRepository->addNew($device);
    }
}