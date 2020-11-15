<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use Dominoes\Infrastructure\Log;

use function sprintf;

class BasicSimulatorStrategy implements SimulatorStrategy
{
    protected Log $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function playerTurn(Player $player, Dominoes $dominoes): void
    {
        $playerPile     = $player->getHandPile();
        $boardPile      = $dominoes->getBoardPile();
        $stockPile      = $dominoes->getStockPile();
        $boardLeftSide  = $boardPile->getLeftSide();
        $boardRightSide = $boardPile->getRightSide();

        foreach ($playerPile->getTiles() as $tile) {
            // board right side
            if ($tile->getRightSide() === $boardLeftSide) {
                $playerPile->removeTile($tile);
                $boardPile->addLeftTile($tile);
                $this->logMovement($player->getName(), $tile, $dominoes->getBoardPile()->getLeftTile());

                return;
            }

            // board left side
            if ($tile->getLeftSide() === $boardRightSide) {
                $playerPile->removeTile($tile);
                $boardPile->addTile($tile);
                $this->logMovement($player->getName(), $tile, $dominoes->getBoardPile()->getRightTile());

                return;
            }
        }

        // nothing found, get from stock and try again
        $playerPile->addTile($stockPile->takeTile());
        $this->playerTurn($player, $dominoes);
    }

    protected function logMovement($playerName, $playerTile, $boardTile): void
    {
        $this->log->write(
            sprintf(
                '%s plays %s to connect to tile %s on the board',
                $playerName,
                $playerTile,
                $boardTile
            )
        );
    }
}
