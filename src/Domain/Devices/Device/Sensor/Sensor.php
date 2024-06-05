<?php 
namespace App\Domain\Devices\Device\Sensor;

use App\Domain\Devices\Events\EventConfig;
use App\Domain\Devices\Sortable;
use App\Domain\Devices\Sensor\SensorActionsConfig;

class Sensor extends Sortable
{
    private array $configuredEvents;

    public function __construct(
        public  readonly int $id,
        private int             $position,
        public  readonly string $name,
        public  readonly SensorActionsConfig $actionsConfig, 
        EventConfig          ...$eventConfig   
    )
    {
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