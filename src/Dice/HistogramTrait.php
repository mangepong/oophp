<?php

namespace Emmu18\Dice;

/**
 * A trait implementing histogram for integers.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  The numbers stored in sequence.
     */
    private $serie = [];



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     * @return string representing the histogram.
     */
    public function printHistogram($list)
    {

            $one = "";
            $start1 = "";
            $stop1 = "";
            $two = "";
            $three = "";
            $four = "";
            $five = "";
            $six = "";
                foreach ($list as $x) {
                    if ($x == 1) {
                        $one .= " * ";
                    }
                    if ($x == 2) {
                        $two .= " * ";
                    }
                    if ($x == 3) {
                        $three .= " * ";
                    }
                    if ($x == 4) {
                        $four .= " * ";
                    }
                    if ($x == 5) {
                        $five .= " * ";
                    }
                    if ($x == 6) {
                        $six .= " * ";
                    }
                }
            ?>
            <ol>
                <?php if ($one != ""): ?>
                <li value = "1"><?= $one ?></li>
                <?php endif ?>

                <?php if ($two != ""): ?>
                <li value = "2"><?= $two ?></li>
                <?php endif ?>

                <?php if ($three != ""): ?>
                <li value = "3"><?= $three ?></li>
                <?php endif ?>

                <?php if ($four != ""): ?>
                <li value = "4"><?= $four ?></li>
                <?php endif ?>

                <?php if ($five != ""): ?>
                <li value = "5"><?= $five ?></li>
                <?php endif ?>

                <?php if ($six != ""): ?>
                <li value = "6"><?= $six ?></li>
                <?php endif ?>
            </ol>
            <?php
        
    }
}
