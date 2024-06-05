<?php

use App\Domain\Devices\Events\EventConfig;

interface IDeviceEventListenner 
{
    public function listenEvent(EventConfig $eventConfig, callable $callback): void;
}