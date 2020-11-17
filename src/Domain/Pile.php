<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use Countable;

use function array_intersect;
use function array_key_last;
use function array_pop;
use function array_splice;
use function array_unshift;
use function count;
use function in_array;
use function shuffle;

/**
 * Basic entity representing group of tiles.
 */
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

    public function addLeftTile(Tile $tile): void
    {
        array_unshift($this->tiles, $tile);
    }

    public function connectTile(Tile $newTile, Tile $existingTile): void
    {
        // check if tiles can be connected
        if ($this->tilesCanBeConnected($newTile, $existingTile) === false) {
            throw new DominoesException('Tiles can not be connected');
        }

        // try to connect to the left side
        if (in_array($this->getLeftSide(), $newTile->toArray())) {
            if ($this->getLeftSide() !== $newTile->getRightSide()) {
                $newTile->rotate();
            }

            $this->addLeftTile($newTile);

            return;
        }

        // try to connect to the right side
        if (in_array($this->getRightSide(), $newTile->toArray())) {
            if ($this->getRightSide() !== $newTile->getLeftSide()) {
                $newTile->rotate();
            }

            $this->addTile($newTile);

            return;
        }

        throw new DominoesException('Tiles can not be connected');
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

    public function getLeftTile(): ?Tile
    {
        return $this->tiles[0] ?? null;
    }

    public function getRightTile(): ?Tile
    {
        return isset($this->tiles[0]) ? $this->tiles[array_key_last($this->tiles)] : null;
    }

    public function getLeftSide(): ?int
    {
        return $this->getLeftTile() ? $this->getLeftTile()->getLeftSide() : null;
    }

    public function getRightSide(): ?int
    {
        return $this->getRightTile() ? $this->getRightTile()->getRightSide() : null;
    }

    public function removeTile(Tile $tile): void
    {
        foreach ($this->tiles as $key => $pileTile) {
            if ($pileTile === $tile) {
                array_splice($this->tiles, $key, 1);

                return;
            }
        }

        throw new DominoesException('Tile not found in the pile');
    }

    protected function tilesCanBeConnected(Tile $newTile, Tile $existingTile): bool
    {
        // existing tile must be on the left or right side
        if ($existingTile !== $this->getLeftTile() && $existingTile !== $this->getRightTile()) {
            return false;
        }

        // tiles must have common pins
        if (! array_intersect($newTile->toArray(), $existingTile->toArray())) {
            return false;
        }

        return true;
    }
}
