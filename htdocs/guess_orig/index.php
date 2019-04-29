<?php
    include("config.php");
    include("autoload.php");
    $action = $_POST["action"] ?? "";
    $guessNum = $_POST["guessNum"] ?? 0;
    $object = new Guess();
    $object->random();
if (!isset($_SESSION["secret"])) {
    $_SESSION["secret"] = $object->number();
}
if (!isset($_SESSION["mode"])) {
    $_SESSION["mode"] = "";
}
if (!isset($_SESSION["tries"])) {
    $_SESSION["tries"] = $object->tries();
}
    $secret = $_SESSION["secret"];
    $tries = $_SESSION["tries"];
    $res = $object->makeGuess($guessNum, $secret);
    include("view/header.php");
?>
    <?php if ($action == "Guess") : ?>
        <?php if ($tries == 0) {
            echo ("You have lost.");
            $_SESSION["mode"] = "disabled";
        } ?>
        <?php if ($guessNum > 100 || $guessNum < 1) {
            // throw new GuessException("Number not allowed, must be under 100 and over 1.");
            echo ("Number not allowed, must be under 100 and over 1.");
        }?>
        <?php $_SESSION["tries"] = $_SESSION["tries"] - 1; ?>
        <p> Your guess <?= $guessNum ?> is <?= $res ?>. </p>
    <?php endif; ?>
    <?php if ($action == "Cheat") : ?>
        <p> The answer is <?= $secret ?>. </p>
    <?php endif; ?>
    <?php
    if ($action == "Reset") {
        session_unset();
    }
    include("view/footer.php");
    ?>
