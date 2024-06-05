<?php 
namespace App\Domain\Devices\Device\Sensor;

enum TresholdType {
    case RANGE; 
    case EXACT;

    public static function fromString(string $type): self
    {
        return match ($type) {
            'RANGE' => self::RANGE,
            'EXACT' => self::EXACT,
            default => throw new \InvalidArgumentException("Invalid treshold type: $type")
        };
    }

    public function validateValue(?float $minValue, ?float $maxValue, ?float $value): void
    {
        match ($this) {
            self::RANGE => $this->validateRangeValue($minValue, $maxValue),
            self::EXACT => $this->validateExactValue($value)
        };
    }

    private function validateRangeValue(?float $minValue, ?float $maxValue): void
    {
        if($minValue === null || $maxValue === null) {
            throw new \InvalidArgumentException("Min and max values must be set");
        }

        if ($minValue >= $maxValue) {
            throw new \InvalidArgumentException("Min value must be less than max value");
        }
    }

    private function validateExactValue(?float $value): void
    {
        if($value === null) {
            throw new \InvalidArgumentException("Value must be set");
        }
    }

    public function toString()
    {
        return match ($this) {
            self::RANGE => 'RANGE',
            self::EXACT => 'EXACT',
            default => ''
        };
    
    }
}