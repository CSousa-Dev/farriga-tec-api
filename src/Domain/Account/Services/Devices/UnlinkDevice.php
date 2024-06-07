<?php
namespace App\Domain\Account\Services\Devices;

use App\Domain\Account\Repository\IUserDevicesListRepository;

class UnlinkDevice
{
    public function __construct(
        private IUserDevicesListRepository $userDevicesListRepository
    ){}

    public function execute(
        string $deviceMacAddress,
        string $userEmail
    )
    {
        if(!$this->userDevicesListRepository->deviceExists($deviceMacAddress))
        {
            throw new \DomainException("Dispositivo não localizado, verifique o endereço MAC informado.");
        }

        if(!$this->userDevicesListRepository->isDeviceAlreadyLinked($deviceMacAddress))
        {
            throw new \DomainException("Este dispositivo não está vinculado a nenhum usuário.");    
        }

        if($this->userDevicesListRepository->currentLinkedUserEmail($deviceMacAddress) != $userEmail)
        {
            throw new \DomainException("Este dispositivo está vinculado a outro usuário e você não tem permissão para desvinculá-lo.");
        }

        $this->userDevicesListRepository->unlinkDevice($deviceMacAddress);
    }
}