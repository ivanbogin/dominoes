<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\Dominoes;
use Dominoes\Domain\Tile;
use PHPUnit\Framework\TestCase;

use function array_map;

class DominoesTest extends TestCase
{
    public function testGenerateTiles(): void
    {
        $dominoes = new Dominoes();
        $tiles    = $dominoes->generateTiles();

        $this->assertCount(28, $tiles);

        $expectedTiles = [
            [0, 0],
            [1, 0],
            [2, 0],
            [3, 0],
            [4, 0],
            [5, 0],
            [6, 0],
            [1, 1],
            [2, 1],
            [3, 1],
            [4, 1],
            [5, 1],
            [6, 1],
            [2, 2],
            [3, 2],
            [4, 2],
            [5, 2],
            [6, 2],
            [3, 3],
            [4, 3],
            [5, 3],
            [6, 3],
            [4, 4],
            [5, 4],
            [6, 4],
            [5, 5],
            [6, 5],
            [6, 6],
        ];

        $actualTiles = array_map(static fn (Tile $tile) => $tile->toArray(), $tiles);

        $this->assertEquals($expectedTiles, $actualTiles);
    }
}
