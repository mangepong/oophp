<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?><h1>Play the game</h1>
<form method="GET">
    <h3>Tärningsspel 100</h3>
    <input type="submit" value="Kasta" name="action" <?= $_SESSION["mode"] ?>>
    <input type="submit" value="Spara" name="action" <?= $_SESSION["mode"] ?>>
    <input type="submit" value="Starta Om" name="action">
    <p> <?= $rest ?> </p>
    <p>Det är nu <?= $turn ?> tur.</p><br><br>
    <p>Spelare 1 har nu <?= $score1 ?> poäng.</p><br>
    <p>Spelare 2 har nu <?= $score2 ?> poäng.</p>
</form>
