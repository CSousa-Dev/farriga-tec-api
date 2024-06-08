<?php 
namespace App\Domain\Devices\Device\Irrigator;

use App\Domain\Devices\Utils\Sortable;
use App\Domain\Devices\Events\EventConfig;
use App\Domain\Devices\Device\Irrigator\IrrigatorActionsConfig;

class Irrigator extends Sortable
{
    private $configuredEvents;
    public function __construct(
        public readonly string $name,
        public readonly string $model,
        public readonly IrrigatorActionsConfig $actionsConfig,
        private         ?string $alias = null,
        public readonly ?int $id = null,
        public          ?int $position = null, 
    ){}

    public function addCondifguredEvents(EventConfig ...$eventConfig): void
    {
        $this->configuredEvents = $eventConfig;
    }

    public function position(): int
    {
        return $this->position;
    }

    public function alias(): ?string
    {
        return $this->alias;
    }

    public function changeAlias(string $newAlias): void
    {
        $this->alias = $newAlias;
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