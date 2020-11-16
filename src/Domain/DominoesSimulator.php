<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use Dominoes\Infrastructure\Log;

use function implode;
use function sprintf;

class DominoesSimulator
{
    protected Dominoes $dominoes;

    protected Log $log;

    protected SimulatorStrategy $simulatorStrategy;

    public function __construct(Dominoes $dominoes, Log $log, SimulatorStrategy $simulatorStrategy)
    {
        $this->dominoes          = $dominoes;
        $this->log               = $log;
        $this->simulatorStrategy = $simulatorStrategy;
    }

    public function play(): void
    {
        $dominoes  = $this->getDominoes();
        $firstTile = $dominoes->getBoardPile()->getTiles()[0];
        $this->log->write('Game starting with first tile: ' . $firstTile);

        while ($dominoes->isThereAWinner() === false) {
            foreach ($dominoes->getPlayers() as $player) {
                try {
                    $this->simulatorStrategy->playerTurn($player, $dominoes);
                } catch (EmptyStockException $emptyStockException) {
                    $this->log->write(sprintf('Stock is empty! Draw'));

                    return;
                }

                $this->logBoard($dominoes->getBoardPile());
                if ($dominoes->isThereAWinner()) {
                    break;
                }
            }
        }

        $this->log->write(sprintf('Player %s has won!', $dominoes->findWinner()->getName()));
    }

    protected function getDominoes(): Dominoes
    {
        return $this->dominoes;
    }

    protected function logBoard(Pile $pile): void
    {
        $this->log->write(sprintf('Board is now: %s', implode(' ', $pile->toStringArray())));
    }
}
