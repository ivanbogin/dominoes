<?php

require __DIR__ . '/vendor/autoload.php';

use Dominoes\Domain\BasicSimulatorStrategy;
use Dominoes\Domain\Dominoes;
use Dominoes\Domain\DominoesSimulator;
use Dominoes\Domain\Player;
use Dominoes\Infrastructure\ConsoleLog;


$dominoes = new Dominoes([new Player('Alice'), new Player('Bob')]);
$dominoes->setupGame();

$log = new ConsoleLog();

$simulator = new DominoesSimulator($dominoes, $log, new BasicSimulatorStrategy($log));
$simulator->play();
