<?php

declare(strict_types=1);

namespace Dominoes\Infrastructure;

interface Log
{
    public function write(string $text): void;
}
