<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\BasicSimulatorStrategy;
use Dominoes\Domain\Dominoes;
use Dominoes\Domain\DominoesSimulator;
use Dominoes\Domain\Player;
use Dominoes\Domain\Tile;
use Dominoes\Infrastructure\ArrayLog;
use PHPUnit\Framework\TestCase;

class DominoesSimulatorTest extends TestCase
{
    public function testPlayTwoPlayers(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);
        $dominoes->setupGame();

        $log = new ArrayLog();

        $simulator = new DominoesSimulator($dominoes, $log, new BasicSimulatorStrategy($log));
        $simulator->play();

        // there must be a winner or an empty stock
        $this->assertTrue($dominoes->isThereAWinner() || $dominoes->getStockPile()->count() === 0);

        // there must be simulator logs
        $this->assertNotEmpty($log->getLogs());
    }

    public function testPlayPlayerPassTurnWhenStockIsEmpty(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);

        $dominoes->getBoardPile()->addTile(new Tile(2, 2));

        // player 1 is going first, but no matching tile, so he skips turn
        $player1->getHandPile()->addTile(new Tile(1, 1));

        // player 2 will win - last matching tile
        $player2->getHandPile()->addTile(new Tile(2, 1));

        $log = new ArrayLog();

        $simulator = new DominoesSimulator($dominoes, $log, new BasicSimulatorStrategy($log));
        $simulator->play();

        // player 2 played and won
        $this->assertEmpty($player2->getHandPile()->getTiles());

        // board contains initial tile [2, 2] and player 2 tile [1, 2]
        $this->assertEquals([[1, 2], [2, 2]], $dominoes->getBoardPile()->toArray());

        // player 1 couldn't play
        $this->assertEquals([[1, 1]], $player1->getHandPile()->toArray());

        $this->assertTrue($dominoes->isThereAWinner());
    }

    public function testPlayDraw(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);

        $dominoes->getBoardPile()->addTile(new Tile(3, 3));

        // player 1 is going first, but no matching tile
        $player1->getHandPile()->addTile(new Tile(1, 1));

        // player 2 also has no matching tile
        $player2->getHandPile()->addTile(new Tile(2, 1));

        $log = new ArrayLog();

        $simulator = new DominoesSimulator($dominoes, $log, new BasicSimulatorStrategy($log));
        $simulator->play();

        // board contains initial tile [3, 3]
        $this->assertEquals([[3, 3]], $dominoes->getBoardPile()->toArray());

        $this->assertFalse($dominoes->isThereAWinner());
        $this->assertCount(0, $dominoes->getStockPile());
    }
}
