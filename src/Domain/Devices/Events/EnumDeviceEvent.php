<?php 
namespace App\Domain\Devices\Events;

enum EnumDeviceEvent 
{
    case DEVICE_TURN_ON;
    case DEVICE_TURN_OFF;

    case DEVICE_MANUAL_USAGE;   

    public function toString(): string
    {
        return match ($this) {
            self::DEVICE_TURN_ON => 'DEVICE_TURN_ON',
            self::DEVICE_TURN_OFF => 'DEVICE_TURN_OFF',
            self::DEVICE_MANUAL_USAGE => 'DEVICE_MANUAL_USAGE',
        };
    }

    public static function fromString(string $type): self | null
    {
        return match ($type) {
            'DEVICE_TURN_ON' => self::DEVICE_TURN_ON,
            'DEVICE_TURN_OFF' => self::DEVICE_TURN_OFF,
            'DEVICE_MANUAL_USAGE' => self::DEVICE_MANUAL_USAGE,
            default => null
        };
    }
}