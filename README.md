# Dominoes game
PHP implementation of classic double six dominoes game developed using test-driven approach.

## Requirements
* PHP 7.4
* Composer

## How to

* Install dependencies with `composer install`
* Run simulation with `composer play` or `php app.php`
* Run tests with `composer test`
* Check test coverage with `composer coverage`

## Rules

Dominoes is a family of games played with rectangular tiles. Each tile is divided into two square ends. Each end is marked with a number (one to six) of spots or is blank. There are 28 tiles, one for each combination of spots and blanks.

* The 28 tiles are shuffled face down and form the stock.
* Each player draws seven tiles.
* Pick a random tile to start the line of play.
* The players alternately extend the line of play with one tile at one of its two ends;
* A tile may only be placed next to another tile, if their respective values on the connecting ends are identical.
* If a player is unable to place a valid tile, they must keep on pulling tiles from the stock until they can.
* The game ends when one player wins by playing their last tile.

