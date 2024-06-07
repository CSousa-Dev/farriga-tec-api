<?php 
namespace App\Application\Account\Devices;

use App\Domain\Account\Services\Devices\LinkDevice;
use App\Domain\Account\Services\Devices\UnlinkDevice;

class UnlinkDeviceService
{
    public function __construct(
        private UnlinkDevice $linkDeviceService
    ){}

    public function execute(string $macAddress, string $userEmail)
    {
        $this->linkDeviceService->execute($macAddress, $userEmail);
    }
}