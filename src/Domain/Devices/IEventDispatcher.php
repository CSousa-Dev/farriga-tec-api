<?php
namespace App\Domain\Devices;

use App\Domain\Devices\Events\EventConfig;

interface IEventDispatcher
{
    public function dispatchEvent(EventConfig $event): void;
}