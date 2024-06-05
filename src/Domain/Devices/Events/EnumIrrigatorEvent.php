<?php 
namespace App\Domain\Devices\Events;

enum EnumIrrigatorEvent
{
    case IRRIGATOR_ON;
    case IRRIGATOR_OFF;
    case IRRIGATION_STARTED;
    case IRRIGATION_STOPPED;
    case IRRIGATION_CHANGE_WATERING_TIME;
    case IRRIGATION_CHANGE_CHECK_INTERVAL;

    public function toString(): string
    {
        return match ($this) {
            self::IRRIGATOR_ON => 'IRRIGATOR_ON',
            self::IRRIGATOR_OFF => 'IRRIGATOR_OFF',
            self::IRRIGATION_STARTED => 'IRRIGATION_STARTED',
            self::IRRIGATION_STOPPED => 'IRRIGATION_STOPPED',
            self::IRRIGATION_CHANGE_WATERING_TIME => 'IRRIGATION_CHANGE_WATERING_TIME',
            self::IRRIGATION_CHANGE_CHECK_INTERVAL => 'IRRIGATION_CHANGE_CHECK_INTERVAL',
        };
    }

    public static function fromString(string $type): self
    {
        return match ($type) {
            'IRRIGATOR_ON' => self::IRRIGATOR_ON,
            'IRRIGATOR_OFF' => self::IRRIGATOR_OFF,
            'IRRIGATION_STARTED' => self::IRRIGATION_STARTED,
            'IRRIGATION_STOPPED' => self::IRRIGATION_STOPPED,
            'IRRIGATION_CHANGE_WATERING_TIME' => self::IRRIGATION_CHANGE_WATERING_TIME,
            'IRRIGATION_CHANGE_CHECK_INTERVAL' => self::IRRIGATION_CHANGE_CHECK_INTERVAL,
            default => null
        };
    }
}