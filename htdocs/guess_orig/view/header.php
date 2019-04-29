<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Guess app</title>

</head>
<body>

<form method="POST">
    <h3>Guess my number (POST)</h3>
    Guess a number between 1 and 100, you have <?= $tries ?> tries left.<br><br>
    <input type="text" name="guessNum">
    <input type="submit" value="Guess" name="action" <?= $_SESSION["mode"]; ?> >
    <input type="submit" value="Reset" name="action">
    <input type="submit" value="Cheat" name="action">
</form>
