<?php 
namespace App\Domain\Account\Services\Devices;
use App\Domain\Account\Repository\IUserDevicesListRepository;

class LinkDevice
{
    public function __construct(
        private IUserDevicesListRepository $userDevicesListRepository
    ){}

    public function execute(
        string $macAddress,
        string $userEmail
    )
    {

        if(!$this->userDevicesListRepository->deviceExists($macAddress))
        {
            throw new \DomainException("Dispositivo não localizado, verifique o endereço MAC informado.");
        }


        if($this->userDevicesListRepository->isDeviceAlreadyLinked($macAddress))
        {
            $currentLinkedUserEmail = $this->userDevicesListRepository->currentLinkedUserEmail($macAddress);

            $message = "Este dispositivo já está vinculado a outro usuário.";

            if($currentLinkedUserEmail == $userEmail)
                $message = "Este dispositivo já está vinculado a sua conta.";

            throw new \DomainException($message);
        }

        $this->userDevicesListRepository->linkDeviceToUser($macAddress, $userEmail);
    }
}