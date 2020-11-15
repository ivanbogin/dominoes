<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use Countable;

use function array_pop;
use function count;
use function shuffle;

class Pile implements Countable
{
    /** @var Tile[] */
    private array $tiles = [];

    /**
     * @return Tile[]
     */
    public function getTiles(): array
    {
        return $this->tiles;
    }

    public function addTile(Tile $tile): void
    {
        $this->tiles[] = $tile;
    }

    public function takeTile(): Tile
    {
        return array_pop($this->tiles);
    }

    public function count(): int
    {
        return count($this->tiles);
    }

    public function clear(): void
    {
        $this->tiles = [];
    }

    public function shuffle(): void
    {
        shuffle($this->tiles);
    }

    /**
     * @return array<int,int>
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this->tiles as $tile) {
            $array[] = $tile->toArray();
        }

        return $array;
    }

    /**
     * @return array<string>
     */
    public function toStringArray(): array
    {
        $array = [];
        foreach ($this->tiles as $tile) {
            $array[] = $tile->__toString();
        }

        return $array;
    }
}
