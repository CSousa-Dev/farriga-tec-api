<?php
namespace App\Domain\Devices\Repository;

use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Device\DeviceList;
use App\Domain\Devices\Device\DeviceType;

interface IDeviceRepository
{
    public function isMacAddressInUse(string $macAddress): bool;
    public function addNew(Device $device): void;
    public function findModel(int $modelId): DeviceType;
    public function modelExists(int $modelId): bool;
    public function findDeviceByMacAddress(string $macAddress): Device | null;
    public function addNewZone(Device $device, int $zonePosition): void;
    public function addNewSensor(Device $device, int $zonePosition, int $sensorPosition): void;
    public function addNewIrrigator(Device $device, int $zonePosition, int $irrigatorPosition): void;
    public function findAllDevicesByUserEmail(string $userEmail): DeviceList;

}