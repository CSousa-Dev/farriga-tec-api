<?php
namespace App\Domain\Devices\Events;

use App\Domain\Devices\Events\EnumDeviceEvent;
use App\Domain\Devices\Events\EnumSensorEvent;
use App\Domain\Devices\Events\EnumIrrigatorEvent;

class EventConfig 
{
    public function __construct(
        public readonly string  $eventName,
        public readonly bool    $canListen,
        public readonly bool    $canEmit,
        public readonly ?string  $listenKey,
        public readonly ?string  $emitKey
    ){
        $this->foundEvent($eventName);
    }

    public function foundEvent(string $eventName)
    {
        $event = EnumDeviceEvent::fromString($eventName);

        if($event !== null) return;

        $event = EnumSensorEvent::fromString($eventName);

        if($event !== null) return;

        $event = EnumIrrigatorEvent::fromString($eventName);

        if($event !== null) return;
        

        throw new \Exception("Invalid event type $eventName");
    }
}