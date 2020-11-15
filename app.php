<?php

require __DIR__ . '/vendor/autoload.php';

use Dominoes\Infrastructure\Console;

$console = new Console();

$console->writeln('hello');
