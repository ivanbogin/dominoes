<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use Dominoes\Infrastructure\Log;

use function implode;
use function in_array;
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
        $boardLeftTile  = $boardPile->getLeftTile();
        $boardRightTile = $boardPile->getRightTile();

        foreach ($playerPile->getTiles() as $tile) {
            // board left side
            if (in_array($boardRightSide, [$tile->getLeftSide(), $tile->getRightSide()])) {
                if ($boardRightSide !== $tile->getLeftSide()) {
                    $tile->rotate();
                }

                $playerPile->removeTile($tile);
                $boardPile->addTile($tile);
                $this->logMovement($player->getName(), $tile, $boardRightTile);

                return;
            }

            // board right side
            if (! in_array($boardLeftSide, [$tile->getLeftSide(), $tile->getRightSide()])) {
                continue;
            }

            if ($boardLeftSide !== $tile->getRightSide()) {
                $tile->rotate();
            }

            $playerPile->removeTile($tile);
            $boardPile->addLeftTile($tile);
            $this->logMovement($player->getName(), $tile, $boardLeftTile);

            return;
        }

        // if there are no tiles left in the stock, the player passes his turn
        if ($stockPile->count() === 0) {
            throw new EmptyStockException('Empty stock');
        }

        // get from stock and try again
        $stockTile = $stockPile->takeTile();
        $playerPile->addTile($stockTile);
        $this->logTakingStock($player->getName(), $stockTile);

        $this->playerTurn($player, $dominoes);
    }

    protected function logMovement(string $playerName, Tile $playerTile, Tile $boardTile): void
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

    protected function logTakingStock(string $playerName, Tile $newTile): void
    {
        $this->log->write(sprintf("%s can't play, drawing tile %s", $playerName, $newTile));
    }

    protected function logPlayerHand(Player $player): void
    {
        $this->log->write(
            sprintf('%s hand: %s', $player->getName(), implode(' ', $player->getHandPile()->toStringArray()))
        );
    }
}
