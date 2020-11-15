<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\Dominoes;
use Dominoes\Domain\DominoesSimulator;
use Dominoes\Domain\Player;
use PHPUnit\Framework\TestCase;

class DominoesSimulatorTest extends TestCase
{
    public function testPlayTwoPlayers(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);
        $dominoes->setupGame();

        $simulator = new DominoesSimulator($dominoes);
        $simulator->play();

        // there must be a winner
        $this->assertTrue($dominoes->isThereAWinner());

        // there must be simulator logs
        $this->assertNotEmpty($simulator->getLogs());
    }
}
