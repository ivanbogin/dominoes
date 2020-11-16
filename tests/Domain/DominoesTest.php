<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\Dominoes;
use Dominoes\Domain\Player;
use Dominoes\Domain\Tile;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function array_map;
use function array_merge;

class DominoesTest extends TestCase
{
    public function testGenerateTiles(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);
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

    public function testSetupGame(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);

        $dominoes->setupGame();

        $this->assertCount(2, $dominoes->getPlayers());
        $this->assertCount(7, $player1->getHandPile());
        $this->assertCount(7, $player2->getHandPile());
        $this->assertCount(1, $dominoes->getBoardPile());
        $this->assertCount(13, $dominoes->getStockPile());

        // Make sure all piles have unique tiles
        $tiles = array_merge(
            $player1->getHandPile()->toStringArray(),
            $player2->getHandPile()->toStringArray(),
            $dominoes->getStockPile()->toStringArray(),
            $dominoes->getBoardPile()->toStringArray(),
        );
        $this->assertCount(28, $tiles);

        // No winner yet
        $this->assertFalse($dominoes->isThereAWinner());
    }

    public function testIsThereAWinnerAllPlayersHaveTiles(): void
    {
        $player1 = new Player('Alice');
        $player2 = new Player('Bob');

        $player1->getHandPile()->addTile(new Tile(0, 0));
        $player2->getHandPile()->addTile(new Tile(1, 1));

        $dominoes = new Dominoes([$player1, $player2]);

        $this->assertFalse($dominoes->isThereAWinner());
    }

    public function testIsThereAWinnerOnePlayerHandEmpty(): void
    {
        $player1 = new Player('Alice');
        $player2 = new Player('Bob');

        $player1->getHandPile()->addTile(new Tile(0, 0));
        $player2->getHandPile()->clear();

        $dominoes = new Dominoes([$player1, $player2]);

        $this->assertTrue($dominoes->isThereAWinner());
    }

    public function testWrongNumberOfPlayers(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Wrong number of players (min 2, max 4)');
        new Dominoes([]);
    }
}
