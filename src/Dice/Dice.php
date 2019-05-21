<?php

namespace Emmu18\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Dice
{
    /**
     * @var int $score1   Score of player 1.
     * @var int $score2   Score of player 2.
     * @var array $dice    Array of the dices.
     */
    public $score1;
    public $score2;
    public $dices;

    /**
     * Constructor to initiate the object with current game settings,
     * if available.
     *
     * @param array $dices An array that will contain all the dices.
     */

    public function __construct($dices = [])
    {
        $this->dices = $dices;
    }



    /**
     * Rolls 3 dices.
     *
     * @param array Defines the dices array.
     */

    public function rollDice()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->dices[$i] = rand(1, 6);
        }
    }




    /**
     * Prints out all the current dices.
     *
     * @return string
     */
    public function printDices()
    {
        return "Tärningarna blev ". $this->dices[0] . ", " . $this->dices[1] . ", " . $this->dices[2] . ".";
    }

    /**
     * Get the array.
     *
     * @return array Return the array of dices.
     */
    public function getDices()
    {
        return $this->dices;
    }
}
