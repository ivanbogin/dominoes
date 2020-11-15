<?php

declare(strict_types=1);

namespace Tests\Dominoes\Domain;

use Dominoes\Domain\Dominoes;
use Dominoes\Domain\Player;
use Dominoes\Domain\Tile;
use PHPUnit\Framework\TestCase;

class DominoesTest extends TestCase
{
    public function testIsThereAWinnerFalse(): void
    {
        $player1 = new Player('Alice');
        $player2 = new Player('Bob');

        $player1->getHandPile()->addTile(new Tile(0, 0));
        $player2->getHandPile()->addTile(new Tile(1, 1));

        $dominoes = new Dominoes([$player1, $player2]);
        $this->assertFalse($dominoes->isThereAWinner());
    }

    public function testIsThereAWinnerTrue(): void
    {
        $player1  = new Player('Alice');
        $player2  = new Player('Bob');
        $dominoes = new Dominoes([$player1, $player2]);
        $this->assertTrue($dominoes->isThereAWinner());
    }
}
