<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use function sprintf;

class BasicSimulatorStrategy implements SimulatorStrategy
{
    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function playerTurn(Player $player, Dominoes $dominoes): void
    {
        $playerPile     = $player->getHandPile();
        $boardPile      = $dominoes->getBoardPile();
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
    }

    protected function logMovement($playerName, $playerTile, $boardTile): void
    {
        $this->logger->addLog(
            sprintf(
                '%s plays %s to connect to tile %s on the board',
                $playerName,
                $playerTile,
                $boardTile
            )
        );
    }
}
