<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\DominoesException;
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

    public function testConnectTileMismatch(): void
    {
        $pile  = new Pile();
        $tile1 = new Tile(2, 1);
        $tile2 = new Tile(3, 3);

        $this->expectException(DominoesException::class);
        $this->expectExceptionMessage('Tiles can not be connected');
        $pile->connectTile($tile1, $tile2);
    }

    public function testConnectTileWrongConnection(): void
    {
        $pile  = new Pile();
        $tile1 = new Tile(2, 1);
        $tile2 = new Tile(6, 1);
        $pile->addTile($tile1);
        $pile->connectTile($tile2, $tile1);
        $this->assertEquals([[2, 1], [1, 6]], $pile->toArray());

        $tile3 = new Tile(1, 1);

        $this->expectException(DominoesException::class);
        $this->expectExceptionMessage('Tiles can not be connected');
        $pile->connectTile($tile3, $tile1);
    }

    public function testConnectTileSuccess(): void
    {
        $pile  = new Pile();
        $tile1 = new Tile(2, 1);
        $tile2 = new Tile(6, 1);
        $pile->addTile($tile1);

        $pile->connectTile($tile2, $tile1);
        $this->assertEquals([[2, 1], [1, 6]], $pile->toArray());

        $tile3 = new Tile(2, 4);
        $pile->connectTile($tile3, $tile1);
        $this->assertEquals([[4, 2], [2, 1], [1, 6]], $pile->toArray());
    }

    public function testRemoveTileNotFoundInPile(): void
    {
        $pile  = new Pile();
        $tile1 = new Tile(2, 1);
        $tile2 = new Tile(6, 1);
        $pile->addTile($tile1);

        $this->expectException(DominoesException::class);
        $this->expectExceptionMessage('Tile not found in the pile');
        $pile->removeTile($tile2);
    }
}
