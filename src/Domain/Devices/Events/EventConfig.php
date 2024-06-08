<?php
namespace App\Domain\Devices\Events;

use App\Domain\Devices\Events\EnumDeviceEvents;
use App\Domain\Devices\Events\EnumIrrigatorEvent;
use App\Domain\Devices\Events\EnumSensorEvent;

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
        $event = EnumDeviceEvents::fromString($eventName);

        if($event !== null) return;

        $event = EnumSensorEvent::fromString($eventName);

        if($event !== null) return;

        $event = EnumIrrigatorEvent::fromString($eventName);

        if($event !== null) return;
        

        throw new \Exception("Invalid event type $eventName");
    }
}