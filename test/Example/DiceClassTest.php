<?php

namespace Emmu18\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceCreateObjectTest extends TestCase
{
    public function testrollDice()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Emmu18\Dice\Dice", $dice);

        $dice->rollDice();
    }

    public function testprintDices()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Emmu18\Dice\Dice", $dice);

        $dice->rollDice();
        $dice->printDices();
    }

    public function testgetDices()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Emmu18\Dice\Dice", $dice);

        $dice->rollDice();
        $res = $dice->getDices();

        $this->assertLessThan(7, $res[0]);
    }
}