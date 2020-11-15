<?php

declare(strict_types=1);

namespace Dominoes\Domain;

class Player
{
    private string $name;

    private Pile $handPile;

    public function __construct(string $name)
    {
        $this->name     = $name;
        $this->handPile = new Pile();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHandPile(): Pile
    {
        return $this->handPile;
    }
}
