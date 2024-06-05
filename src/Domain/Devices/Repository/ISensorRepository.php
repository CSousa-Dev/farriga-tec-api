<?php 
namespace App\Domain\Devices\Repository;

use App\Domain\Devices\Device\Sensor\Sensor;

interface ISensorRepository
{
    public function buildSensorModel(int $modelId): Sensor;
    public function modelExists(int $modelId): bool;
}