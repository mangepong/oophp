<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if (!isset($_SESSION["mode"])) {
    $_SESSION["mode"] = "";
}

?><h1>Play the game</h1>
<form method="POST">
    <h3>Guess my number (POST)</h3>
    Guess a number between 1 and 100, you have <?= $tries ?> tries left.<br><br>
    <input type="text" name="guessNum">
    <input type="submit" value="Guess" name="action" <?= $_SESSION["mode"]; ?> >
    <input type="submit" value="Reset" name="action">
    <input type="submit" value="Cheat" name="action">
    <p><?= $rest ?></p>
</form>
