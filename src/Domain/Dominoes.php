<?php

declare(strict_types=1);

namespace Dominoes\Domain;

class Dominoes
{
    public const SET_SIZE = 6;

    /**
     * @return Tile[]
     */
    public function generateTiles(): array
    {
        $tiles = [];
        for ($right = 0; $right < self::SET_SIZE + 1; $right++) {
            for ($left = $right; $left < self::SET_SIZE + 1; $left++) {
                $tiles[] = new Tile($left, $right);
            }
        }

        return $tiles;
    }
}
