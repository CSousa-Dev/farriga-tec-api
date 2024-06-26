<?php
namespace App\Domain\Devices\Utils;

use App\Domain\Devices\Utils\Sortable;

class PositionConfig extends Sortable
{
    public function __construct(
        public ?int $position,
        public readonly int $id
    ){}


    public function id(): int
    {
        return $this->id;
    }

    public function position(): int | null
    {
        return $this->position;
    }

    public function changePosition(int $newPosition): void
    {
        $this->position = $newPosition;
    }
}