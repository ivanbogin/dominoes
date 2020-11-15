<?php

declare(strict_types=1);

namespace Dominoes\Domain;

class BasicSimulatorStrategy implements SimulatorStrategy
{
    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function playerTurn(Player $player, Dominoes $dominoes): void
    {

    }
}
