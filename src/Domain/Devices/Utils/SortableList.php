<?php 
namespace App\Domain\Devices;

use App\Domain\Devices\Utils\PositionConfig;
use Traversable;

abstract class SortableList implements \IteratorAggregate
{
    /**
     * @var Sortable[]
     */
    protected array $items = [];

    public function sortByPosition(): void
    {
        usort($this->items, function(Sortable $a, Sortable $b) {
            return $a->position() <=> $b->position();
        });
    }

    public function changePositions(PositionConfig ...$newPosition)
    {
        if(count($newPosition) !== count($this->items)) {
            throw new \InvalidArgumentException('Invalid number of positions');
        }

        $usedPositions = [];

       
        foreach($newPosition as $position) {
            if(in_array($position->position(), $usedPositions)) {
                throw new \InvalidArgumentException('Duplicated position found in new positions array.');
            }

            $usedPositions[] = $position->position();
            $this->items[$position->id()]->changePosition($position->position());
        }
    }

    public function nextPosition(): int
    {
        return count($this->items) + 1;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }
}