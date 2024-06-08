<?php 
namespace App\Domain\Devices\Utils;

abstract class Sortable
{
    public ?int $position;
    public abstract function id(): int;
    public abstract function position(): int | null;
    public function changePosition(int $newPosition)
    {
        $this->position = $newPosition;
    }
}