<?php 
namespace App\Domain\Devices\Device\Sensor;

use App\Domain\Devices\Device\Sensor\TresholdType;
use DateTimeImmutable;

class Treshold
{
    public function __construct(
        private TresholdType $tresholdType,
        private DateTimeImmutable $configuredAt,
        private ?int $value = null,
        private ?int $minValue = null,
        private ?int $maxValue = null
    ){}

    public function checkValues()
    {
        $this->tresholdType->validateValue($this->value, $this->minValue, $this->maxValue);
    }
}