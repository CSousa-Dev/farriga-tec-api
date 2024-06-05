<?php 
namespace App\Domain\Devices\Repository;

use App\Domain\Devices\Irrigator\Irrigator;

interface IIrrigatorRepository
{
    public function buildIrrigatorModel(int $modelId): Irrigator;
    public function modelExists(int $modelId): bool;
}