<?php 
namespace App\Domain\Devices\Device\Sensor;

use App\Domain\Devices\Utils\Sortable;
use App\Domain\Devices\Events\EventConfig;
use App\Domain\Devices\Device\Sensor\SensorActionsConfig;

class Sensor extends Sortable
{
    private array $configuredEvents = [];

    public function __construct(
        public  readonly string $model,  
        public  readonly string $name,
        public  readonly SensorActionsConfig $actionsConfig, 
        public  readonly ?string $unit  = null,
        public  readonly ?int $id        = null,
        public           ?int $position = null,
        private          ?string $alias = null,
    )
    {}

    public function position(): int
    {
        return $this->position;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function addCondifguredEvents(EventConfig ...$eventConfig): void
    {
        $this->configuredEvents = $eventConfig;
    }

    /**     
     * @return EventConfig[]
     */
    public function configuredEvents()
    {
        return $this->configuredEvents;
    }

    public function alias(): ?string
    {
        return $this->alias;
    }

    public function changeAlias(string $newAlias): void
    {
        $this->alias = $newAlias;
    }

    public function changePosition(int $newPosition): void
    {
        $this->position = $newPosition;
    }
}