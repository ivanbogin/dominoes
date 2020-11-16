<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use Dominoes\Infrastructure\Log;

use function sprintf;

/**
 * Dominoes play simulator using specified strategy.
 */
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

        while ($this->simulatorStrategy->canPlay($dominoes)) {
            foreach ($dominoes->getPlayers() as $player) {
                $this->simulatorStrategy->playerTurn($player, $dominoes);
                if ($this->simulatorStrategy->canPlay($dominoes) === false) {
                    break;
                }
            }
        }

        if ($dominoes->isThereAWinner()) {
            $this->log->write(sprintf('Player %s has won!', $dominoes->findWinner()->getName()));
        } elseif ($dominoes->getStockPile()->count() === 0) {
            $this->log->write(sprintf('Stock is empty! Draw'));
        }
    }

    protected function getDominoes(): Dominoes
    {
        return $this->dominoes;
    }
}
