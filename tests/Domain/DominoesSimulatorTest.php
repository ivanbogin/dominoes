<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\BasicSimulatorStrategy;
use Dominoes\Domain\Dominoes;
use Dominoes\Domain\DominoesSimulator;
use Dominoes\Domain\Player;
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
}
