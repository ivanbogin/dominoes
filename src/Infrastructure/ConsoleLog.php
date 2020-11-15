<?php

declare(strict_types=1);

namespace Dominoes\Infrastructure;

use function fwrite;

use const PHP_EOL;
use const STDOUT;

class ConsoleLog implements Log
{
    public function write(string $text): void
    {
        fwrite(STDOUT, $text . PHP_EOL);
    }
}
