<?php 
namespace App\Application\Account\Devices;

use App\Domain\Account\Services\Devices\LinkDevice;

class LinkDeviceService
{
    public function __construct(
        private LinkDevice $linkDeviceService
    ){}

    public function execute(string $macAddress, string $userEmail)
    {
        $this->linkDeviceService->execute($macAddress, $userEmail);
    }
}