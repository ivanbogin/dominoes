<?php

declare(strict_types=1);

namespace Dominoes\Domain;

use function count;
use function shuffle;

/**
 * Classic double six dominoes game.
 * Sets up a game according to the rules.
 */
class Dominoes
{
    public const SET_SIZE = 6;

    /** @var Player[] */
    protected array $players;

    private Pile $stockPile;

    private Pile $boardPile;

    /**
     * @param array<Player> $players
     */
    public function __construct(array $players)
    {
        if (count($players) < 2 || count($players) > 4) {
            throw new DominoesException('Wrong number of players (min 2, max 4)');
        }

        $this->players   = $players;
        $this->stockPile = new Pile();
        $this->boardPile = new Pile();
    }

    /**
     * Setup a game according to the rules.
     */
    public function setupGame(): void
    {
        // The 28 tiles are shuffled face down and form the stock
        $tiles = $this->generateTiles();
        shuffle($tiles);
        foreach ($tiles as $tile) {
            $this->getStockPile()->addTile($tile);
        }

        // Each player draws seven tiles
        $stockPile = $this->getStockPile();
        foreach ($this->getPlayers() as $player) {
            $playerPile = $player->getHandPile();
            while ($playerPile->count() < 7) {
                $playerPile->addTile($stockPile->takeTile());
            }
        }

        // Pick a random tile to start the line of play
        $this->getBoardPile()->addTile($this->getStockPile()->takeTile());
    }

    /**
     * Tiles set is specific to the game.
     *
     * @return Tile[]
     */
    public function generateTiles(): array
    {
        $tiles = [];
        for ($right = 0; $right < self::SET_SIZE + 1; $right++) {
            for ($left = $right; $left < self::SET_SIZE + 1; $left++) {
                $tiles[] = new Tile($left, $right);
            }
        }

        return $tiles;
    }

    /**
     * The game ends when one player wins by playing their last tile.
     */
    public function isThereAWinner(): bool
    {
        return $this->findWinner() !== null;
    }

    public function findWinner(): ?Player
    {
        foreach ($this->getPlayers() as $player) {
            if ($player->getHandPile()->count() === 0) {
                return $player;
            }
        }

        return null;
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getStockPile(): Pile
    {
        return $this->stockPile;
    }

    public function getBoardPile(): Pile
    {
        return $this->boardPile;
    }
}
