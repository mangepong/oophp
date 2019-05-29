<?php

namespace Anax\View;

/**
 * Render content within an article.
 */
// $object = $this->app->session->get("object");
// $dice = $this->app->session->get("dice2");
?><h1>Play the game</h1>
<form method="GET">
    <h3>Tärningsspel 100 (V.2)</h3>
    <input type="submit" value="Kasta" name="action" <?= $_SESSION["mode"] ?>>
    <input type="submit" value="Spara" name="action" <?= $_SESSION["mode"] ?>>
    <input type="submit" value="Starta Om" name="action">
    <p> <?= $rest ?> </p>
    <p>Det är nu <?= $turn ?>s tur.</p><br><br>
    <p>Histogram</p>
    <p> <?= $dice->printHistogram($object->getDices()) ?> </p>
    <p>Spelare 1 har nu <?= $score1 ?> poäng.</p><br>
    <p>Datorn har nu <?= $score2 ?> poäng.</p>
</form>
