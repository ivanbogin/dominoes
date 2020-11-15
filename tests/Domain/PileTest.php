<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\Pile;
use Dominoes\Domain\Tile;
use PHPUnit\Framework\TestCase;

class PileTest extends TestCase
{
    public function testGetLeftTile(): void
    {
        $pile = new Pile();
        $pile->addTile(new Tile(0, 1));
        $pile->addTile(new Tile(2, 3));
        $pile->addTile(new Tile(4, 5));

        $this->assertEquals($pile->getLeftTile()->toArray(), [0, 1]);
    }

    public function testGetRightTile(): void
    {
        $pile = new Pile();
        $pile->addTile(new Tile(0, 1));
        $pile->addTile(new Tile(2, 3));
        $pile->addTile(new Tile(4, 5));

        $this->assertEquals($pile->getRightTile()->toArray(), [4, 5]);
    }

    public function testRemoveTile(): void
    {
        $pile  = new Pile();
        $tile1 = new Tile(0, 1);
        $tile2 = new Tile(2, 3);
        $tile3 = new Tile(4, 5);

        $pile->addTile($tile1);
        $pile->addTile($tile2);
        $pile->addTile($tile3);

        $pile->removeTile($tile2);

        $this->assertEquals($pile->toArray(), [[0, 1], [4, 5]]);
    }
}
