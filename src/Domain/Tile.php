<?php

declare(strict_types=1);

namespace Dominoes\Domain;

class Tile
{
    private int $leftSide;
    private int $rightSide;

    public function __construct(int $leftSide, int $rightSide)
    {
        $this->leftSide  = $leftSide;
        $this->rightSide = $rightSide;
    }

    public function getLeftSide(): int
    {
        return $this->leftSide;
    }

    public function getRightSide(): int
    {
        return $this->rightSide;
    }

    /**
     * @return array<int,int>
     */
    public function toArray(): array
    {
        return [$this->leftSide, $this->rightSide];
    }

    public function __toString(): string
    {
        return '<' . $this->leftSide . ':' . $this->rightSide . '>';
    }
}
