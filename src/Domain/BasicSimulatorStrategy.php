<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use Dominoes\Infrastructure\Log;

use function implode;
use function in_array;
use function sprintf;

/**
 * Simulates actual gameplay according to the rules.
 * Logs actions to log.
 */
class BasicSimulatorStrategy implements SimulatorStrategy
{
    protected Log $log;

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    /**
     * Simulates basic player logic based on the game rules.
     */
    public function playerTurn(Player $player, Dominoes $dominoes): void
    {
        $move = $this->findPossibleMove($player, $dominoes);

        if ($move) {
            $player->getHandPile()->removeTile($move[0]);
            $dominoes->getBoardPile()->connectTile($move[0], $move[1]);
            $this->logMovement($player->getName(), $move[0], $move[1]);
            $this->logBoard($dominoes->getBoardPile());

            return;
        }

        // if there are no tiles left in the stock, the player passes his turn
        if ($dominoes->getStockPile()->count() === 0) {
            return;
        }

        // get from stock and try again
        $stockTile = $dominoes->getStockPile()->takeTile();
        $player->getHandPile()->addTile($stockTile);
        $this->logTakingStock($player->getName(), $stockTile);

        $this->playerTurn($player, $dominoes);
    }

    /**
     * This strategy can be played until all players can move and stock is not empty.
     */
    public function canPlay(Dominoes $dominoes): bool
    {
        // player with empty hand is a winner
        foreach ($dominoes->getPlayers() as $player) {
            if ($player->getHandPile()->count() === 0) {
                return false;
            }
        }

        // find if someone can play
        foreach ($dominoes->getPlayers() as $player) {
            if ($this->findPossibleMove($player, $dominoes) !== null) {
                return true;
            }
        }

        return $dominoes->getStockPile()->count() > 0;
    }

    /**
     * Returns possible player movement according to the game rules (very basic).
     *
     * @return array<Tile,Tile>|null
     */
    protected function findPossibleMove(Player $player, Dominoes $dominoes): ?array
    {
        $boardPile = $dominoes->getBoardPile();

        // go through player tiles and see if he has tile matching left or right side of the game board
        foreach ($player->getHandPile()->getTiles() as $tile) {
            if (in_array($boardPile->getLeftSide(), $tile->toArray())) {
                return [$tile, $boardPile->getLeftTile()];
            }

            if (in_array($boardPile->getRightSide(), $tile->toArray())) {
                return [$tile, $boardPile->getRightTile()];
            }
        }

        return null;
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

    protected function logBoard(Pile $pile): void
    {
        $this->log->write(sprintf('Board is now: %s', implode(' ', $pile->toStringArray())));
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
