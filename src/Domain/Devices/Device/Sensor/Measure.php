<?php 
namespace App\Domain\Devices\Device\Sensor;

class Measure
{
    public function __construct(
        public readonly string $id,
        public readonly string $value,
        public readonly string $timestamp
    )
    {}
}