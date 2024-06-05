<?php 
namespace App\Domain\Devices\Device\UserPermissions;

enum EnumPermissions
{
    case GRANT_PERMISSION;
    case GRANT_ALL_PERMISSION;
    case CHANGE_USAGE_MODE;
    case LISTEN_SENSOR_EVENTS;
    case LISTEN_IRRIGATION_EVENTS;
    case CHANGE_SENSOR_TRESHOLD;
    case POWER_ON_SENSOR;
    case POWER_OFF_SENSOR;
    case POWER_ON_DEVICE;
    case POWER_OFF_DEVICE;
    case START_IRRIGATION_EVENT;
    case STOP_IRRIGATION_EVENT;
    case CHANGE_IRRIGATION_WATERING_TIME;
    case CHANGE_IRRIGATION_CHECK_INTERVAL;



    public function toString(): string
    {
        return match ($this) {
            self::GRANT_PERMISSION => 'GRANT_PERMISSION',
            self::GRANT_ALL_PERMISSION => 'GRANT_ALL_PERMISSION',
            self::CHANGE_USAGE_MODE => 'CHANGE_USAGE_MODE',
            self::LISTEN_SENSOR_EVENTS => 'LISTEN_SENSOR_EVENTS',
            self::LISTEN_IRRIGATION_EVENTS => 'LISTEN_IRRIGATION_EVENTS',
            self::CHANGE_SENSOR_TRESHOLD => 'CHANGE_SENSOR_TRESHOLD',
            self::POWER_ON_SENSOR => 'POWER_ON_SENSOR',
            self::POWER_OFF_SENSOR => 'POWER_OFF_SENSOR',
            self::POWER_ON_DEVICE => 'POWER_ON_DEVICE',
            self::POWER_OFF_DEVICE => 'POWER_OFF_DEVICE',
            self::START_IRRIGATION_EVENT => 'START_IRRIGATION_EVENT',
            self::STOP_IRRIGATION_EVENT => 'STOP_IRRIGATION_EVENT',
            self::CHANGE_IRRIGATION_WATERING_TIME => 'CHANGE_IRRIGATION_WATERING_TIME',
            self::CHANGE_IRRIGATION_CHECK_INTERVAL => 'CHANGE_IRRIGATION_CHECK_INTERVAL',
        };
    }

    public static function fromString(string $type): self
    {
        return match ($type) {
            'GRANT_PERMISSION' => self::GRANT_PERMISSION,
            'GRANT_ALL_PERMISSION' => self::GRANT_ALL_PERMISSION,
            'CHANGE_USAGE_MODE' => self::CHANGE_USAGE_MODE,
            'CHANGE_ALL_SENSOR_TRESHOLD' => self::CHANGE_SENSOR_TRESHOLD,
            'POWER_ON_ALL_SENSOR' => self::POWER_ON_SENSOR,
            'POWER_OFF_ALL_SENSOR' => self::POWER_OFF_SENSOR,
            'POWER_ON_DEVICE' => self::POWER_ON_DEVICE,
            'POWER_OFF_DEVICE' => self::POWER_OFF_DEVICE,
            'START_ALL_IRRIGATION_EVENT' => self::START_IRRIGATION_EVENT,
            'STOP_ALL_IRRIGATION_EVENT' => self::STOP_IRRIGATION_EVENT,
            'CHANGE_ALL_IRRIGATION_WATERING_TIME' => self::CHANGE_IRRIGATION_WATERING_TIME,
            'CHANGE_ALL_IRRIGATION_CHECK_INTERVAL' => self::CHANGE_IRRIGATION_CHECK_INTERVAL,
            default => null
        };
    }

    public static function allPermissions(): array
    {
        return [
            self::GRANT_PERMISSION,
            self::GRANT_ALL_PERMISSION,
            self::CHANGE_USAGE_MODE,
            self::LISTEN_SENSOR_EVENTS,
            self::LISTEN_IRRIGATION_EVENTS,
            self::CHANGE_SENSOR_TRESHOLD,
            self::POWER_ON_SENSOR,
            self::POWER_OFF_SENSOR,
            self::POWER_ON_DEVICE,
            self::POWER_OFF_DEVICE,
            self::START_IRRIGATION_EVENT,
            self::STOP_IRRIGATION_EVENT,
            self::CHANGE_IRRIGATION_WATERING_TIME,
            self::CHANGE_IRRIGATION_CHECK_INTERVAL,
        ];
    }
}