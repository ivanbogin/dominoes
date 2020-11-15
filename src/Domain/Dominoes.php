<?php

declare(strict_types=1);

namespace Dominoes\Domain;

class Dominoes
{
    public const SET_SIZE = 6;

    /** @var Player[] */
    protected array $players;

    /**
     * @param array<Player> $players
     */
    public function __construct(array $players)
    {
        $this->players = $players;
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
        foreach ($this->players as $player) {
            if ($player->getHandPile()->count() === 0) {
                return true;
            }
        }

        return false;
    }
}
