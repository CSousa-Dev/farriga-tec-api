<?php
namespace App\Domain\Devices\Device\Irrigator;

class IrrigatorActionsConfig 
{
    public function __construct(
        public readonly bool $canManualControllIrrigation = false,
        public readonly bool $canChangeWateringTime       = false,
        public readonly bool $canChangeCheckInterval      = false,
        public readonly bool $canTurOnTurnOff             = false
    )
    {}
}