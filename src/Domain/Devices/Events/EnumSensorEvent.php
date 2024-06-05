<?php 
namespace App\Domain\Devices\Events;

enum EnumSensorEvent
{
    case SENSOR_ON;
    case SENSOR_OFF;
    case SENSOR_MEASURED;
    case SENSOR_TRESHOLD_CHANGE;

    public function toString(): string
    {
        return match ($this) {
            self::SENSOR_ON => 'SENSOR_ON',
            self::SENSOR_OFF => 'SENSOR_OFF',
            self::SENSOR_MEASURED => 'SENSOR_MEASURED',
            self::SENSOR_TRESHOLD_CHANGE => 'SENSOR_TRESHOLD_CHANGE',
        };
    }

    public static function fromString(string $type): self
    {
        return match ($type) {
            'SENSOR_ON' => self::SENSOR_ON,
            'SENSOR_OFF' => self::SENSOR_OFF,
            'SENSOR_MEASURED' => self::SENSOR_MEASURED,
            'SENSOR_TRESHOLD_CHANGE' => self::SENSOR_TRESHOLD_CHANGE,
            default => null
        };
    }
}