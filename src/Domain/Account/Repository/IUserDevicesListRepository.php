<?php 
namespace App\Domain\Account\Repository;

interface IUserDevicesListRepository
{
    public function linkDeviceToUser(string $macAddress, string $userEmail): void;
    public function isDeviceAlreadyLinked(string $macAddress): bool;
    public function currentLinkedUserEmail(string $macAddress): string;
    public function unlinkDevice(string $macAddress): void;
    public function deviceExists(string $macAddress): bool;

    // public function getDevicesList(int $userId): array;
}