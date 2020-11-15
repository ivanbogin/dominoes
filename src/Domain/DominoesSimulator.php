<?php

declare(strict_types=1);

namespace Dominoes\Domain;

class DominoesSimulator
{
    private Dominoes $dominoes;

    private array $logs;

    public function __construct(Dominoes $dominoes)
    {
        $this->dominoes = $dominoes;
    }

    public function play(): void
    {
    }

    public function getDominoes(): Dominoes
    {
        return $this->dominoes;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }
}
