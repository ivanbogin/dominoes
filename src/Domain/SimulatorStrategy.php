<?php

declare(strict_types=1);

namespace Dominoes\Domain;

interface SimulatorStrategy
{
    public function canPlay(Dominoes $dominoes): bool;

    public function playerTurn(Player $player, Dominoes $dominoes): void;
}
