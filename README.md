# Dominoes Game
PHP implementation of classic double six dominoes game developed using test-driven approach.

## Requirements
* PHP 7.4
* Composer

## Implementation Approach
Game is non-interactive (yet) and just simulates 2 players playing double six dominoes game with a simplified rules:
* Until one player hand is empty - then he wins
* Or until stock is empty - then it's a draw and no one wins

* Identify entities for dominoes game
    * `Dominoes` game set
    * `Tile` single tile for dominoes game
    * `Player` dominoes player
    * `Pile` contain tiles, used by `Dominoes` board and stock, and by `Player` in hand
* Identify business logic according to requirements
   * `DominoesSimulator` knows how to run Dominoes game simulation
   * `BasicSimulatorStrategy` knows how Player can play basic dominoes according to the rules
* Development cycle
    * Write tests for required logic
    * Write implementation until tests pass
    * Refactor, cleanup
    * Repeat

## How To

* Install dependencies with `composer install`
* Run simulation with `composer play` or `php app.php`
* Run tests with `composer test`
* Check test coverage with `composer coverage`

## Game description & Rules

Dominoes is a family of games played with rectangular tiles. Each tile is divided into two square ends. Each end is marked with a number (one to six) of spots or is blank. There are 28 tiles, one for each combination of spots and blanks.

* The 28 tiles are shuffled face down and form the stock.
* Each player draws seven tiles.
* Pick a random tile to start the line of play.
* The players alternately extend the line of play with one tile at one of its two ends;
* A tile may only be placed next to another tile, if their respective values on the connecting ends are identical.
* If a player is unable to place a valid tile, they must keep on pulling tiles from the stock until they can.
* The game ends when one player wins by playing their last tile.

