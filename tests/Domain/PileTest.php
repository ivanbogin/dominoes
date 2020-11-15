<?php

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\Pile;
use Dominoes\Domain\Tile;
use PHPUnit\Framework\TestCase;

class PileTest extends TestCase
{
    public function testGetLeftTile()
    {
        $pile = new Pile();
        $pile->addTile(new Tile(0, 1));
        $pile->addTile(new Tile(2, 3));
        $pile->addTile(new Tile(4, 5));

        $this->assertEquals($pile->getLeftTile()->toArray(), [0, 1]);
    }

    public function testGetRightTile()
    {
        $pile = new Pile();
        $pile->addTile(new Tile(0, 1));
        $pile->addTile(new Tile(2, 3));
        $pile->addTile(new Tile(4, 5));

        $this->assertEquals($pile->getRightTile()->toArray(), [4, 5]);
    }
}
