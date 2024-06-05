<?php 
namespace App\Domain\Devices\Irrigator;

use App\Domain\Devices\Sortable;
use App\Domain\Devices\Device\Irrigator\IrrigatorActionsConfig;
use App\Domain\Devices\Events\EventConfig;

class Irrigator extends Sortable
{
    private $configuredEvents;
    public function __construct(
        public readonly int $id,
        private int $position, 
        private string $name,
        public readonly IrrigatorActionsConfig $irrigatorActionsConfig,
        EventConfig ...$eventConfig
    ){
        $this->configuredEvents = $eventConfig;
    }

    public function position(): int
    {
        return $this->position;
    }

    public function id(): int
    {
        return $this->id;
    }

    /**     
     * @return EventConfig[]
     */
    public function configuredEvents()
    {
        return $this->configuredEvents;
    }
}