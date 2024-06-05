<?php 
namespace App\Domain\Devices\Events;

enum EnumDeviceEvents 
{
    case DEVICE_TURN_ON;
    case DEVICE_TURN_OFF;

    public function toString(): string
    {
        return match ($this) {
            self::DEVICE_TURN_ON => 'DEVICE_TURN_ON',
            self::DEVICE_TURN_OFF => 'DEVICE_TURN_OFF',
        };
    }

    public static function fromString(string $type): self
    {
        return match ($type) {
            'DEVICE_TURN_ON' => self::DEVICE_TURN_ON,
            'DEVICE_TURN_OFF' => self::DEVICE_TURN_OFF,
            default => null
        };
    }
}