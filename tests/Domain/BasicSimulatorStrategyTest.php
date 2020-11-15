<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\BasicSimulatorStrategy;
use Dominoes\Domain\Dominoes;
use Dominoes\Domain\Logger;
use Dominoes\Domain\Player;
use Dominoes\Domain\Tile;
use PHPUnit\Framework\TestCase;

class BasicSimulatorStrategyTest extends TestCase
{
    public function testPlayerTurnRightSide(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);

        $dominoes->getBoardPile()->addTile(new Tile(2, 1));

        $player1->getHandPile()->addTile(new Tile(1, 0));

        $strategy = new BasicSimulatorStrategy(new Logger());
        $strategy->playerTurn($player1, $dominoes);

        $this->assertEquals([[2, 1], [1, 0]], $dominoes->getBoardPile()->toArray());
        $this->assertEmpty($player1->getHandPile()->getTiles());
    }

    public function testPlayerTurnLeftSide(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);

        $dominoes->getBoardPile()->addTile(new Tile(4, 2));

        $player1->getHandPile()->addTile(new Tile(6, 4));

        $strategy = new BasicSimulatorStrategy(new Logger());
        $strategy->playerTurn($player1, $dominoes);

        $this->assertEquals([[6, 4], [4, 2]], $dominoes->getBoardPile()->toArray());
        $this->assertEmpty($player1->getHandPile()->getTiles());
    }
}
