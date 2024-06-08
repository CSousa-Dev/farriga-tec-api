<?php 
namespace App\Domain\Devices\Events;

enum EnumIrrigatorEvent
{
    case IRRIGATION_ON;
    case IRRIGATION_OFF;
    case IRRIGATION_START;
    case IRRIGATION_STOP;
    case IRRIGATION_CHANGE_WATERING_TIME;
    case IRRIGATION_CHANGE_CHECK_INTERVAL;

    public function toString(): string
    {
        return match ($this) {
            self::IRRIGATION_ON => 'IRRIGATION_ON',
            self::IRRIGATION_OFF => 'IRRIGATION_OFF',
            self::IRRIGATION_START => 'IRRIGATION_START',
            self::IRRIGATION_STOP => 'IRRIGATION_STOP',
            self::IRRIGATION_CHANGE_WATERING_TIME => 'IRRIGATION_CHANGE_WATERING_TIME',
            self::IRRIGATION_CHANGE_CHECK_INTERVAL => 'IRRIGATION_CHANGE_CHECK_INTERVAL',
        };
    }

    public static function fromString(string $type): self | null
    {
        return match ($type) {
            'IRRIGATION_ON' => self::IRRIGATION_ON,
            'IRRIGATION_OFF' => self::IRRIGATION_OFF,
            'IRRIGATION_START' => self::IRRIGATION_START,
            'IRRIGATION_STOP' => self::IRRIGATION_STOP,
            'IRRIGATION_CHANGE_WATERING_TIME' => self::IRRIGATION_CHANGE_WATERING_TIME,
            'IRRIGATION_CHANGE_CHECK_INTERVAL' => self::IRRIGATION_CHANGE_CHECK_INTERVAL,
            default => null
        };
    }
}