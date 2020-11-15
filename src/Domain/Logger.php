<?php

declare(strict_types=1);

namespace Dominoes\Domain;

class Logger
{
    private array $logs;

    public function __construct()
    {
    }

    public function addLog(string $message): void
    {
        $this->logs[] = $message;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }
}
