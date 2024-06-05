<?php 
namespace App\Domain\Devices;

use App\Domain\Devices\Events\EventConfig;

interface IEventConfigRepository
{
    public function getEventConfig(string $type): EventConfig;
}