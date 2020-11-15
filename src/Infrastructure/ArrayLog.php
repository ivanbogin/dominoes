<?php

declare(strict_types=1);

namespace Dominoes\Infrastructure;

class ArrayLog implements Log
{
    private array $logs = [];

    public function write(string $text): void
    {
        $this->logs[] = $text;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }
}
