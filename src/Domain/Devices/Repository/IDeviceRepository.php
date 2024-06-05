<?php
namespace App\Domain\Devices\Repository;

use App\Domain\Devices\Device\Device;
use App\Domain\Devices\Device\Zone\Zone;
use App\Domain\Devices\Device\DeviceType;
use App\Domain\Devices\Irrigator\Irrigator;
use App\Domain\Devices\Device\Sensor\Sensor;
use App\Infra\Doctrine\Entity\Devices\SensorType;
use App\Infra\Doctrine\Entity\Devices\IrrigatorType;

interface IDeviceRepository
{
    public function isMacAddressInUse(string $macAddress): bool;
    public function addNew(Device $device): void;
    public function findModel(int $modelId): DeviceType;
    public function modelExists(int $modelId): bool;
    public function findDeviceByMacAddress(string $macAddress): Device | null;
    public function addNewZone(Device $device, int $zonePosition): void;
    // public function addZoneToDevice(Zone $zone): void;
    // public function getDeviceType(int $deviceTypeId): DeviceType;   
    // public function getSensorType(int $sensorTypeId): SensorType;
    // public function getIrrigatorType(int $irrigatorTypeId): IrrigatorType;
    // public function addSensorToZone(int $zoneId, Sensor $sensor): void;
    // public function addIrrigatorToZone(int $zoneId, Irrigator $irrigator): void;
}