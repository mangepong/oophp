<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for the gamestart

    // $game = new Emmu18\Guess\Guess();
    // $_SESSION["secret"] = $game->number();
    // $_SESSION["tries"] = $game->tries();
    return $app->response->redirect("guess/play");
});



/**
 * Returning a JSON message with Hello World.
 */
$app->router->get("guess/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play the game";
    $action = $_POST["action"] ?? "";
    $guessNum = $_POST["guessNum"] ?? 0;
    $object = new Emmu18\Guess\Guess();
    $object->random();
    $_SESSION["mode"] = "enabled";
    $rest = "";
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

    if ($action == "Reset") {
        session_unset();
    }

    $data = [
        "tries" => $tries,
        "rest" => $rest
    ];
    $app->page->add("guess/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

$app->router->post("guess/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play the game";
    $action = $_POST["action"] ?? "";
    $guessNum = $_POST["guessNum"] ?? 0;
    $object = new Emmu18\Guess\Guess();
    $object->random();
    $rest = "";
    $_SESSION["mode"] = "enabled";
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
    ?>
    <?php if ($action == "Guess") : ?>
        <?php if ($tries == 0) {
            // echo ("You have lost.");

            $rest = "You have lost";
            $_SESSION["mode"] = "disabled";
        } ?>
        <?php if ($guessNum > 100 || $guessNum < 1) {
            // throw new GuessException("Number not allowed, must be under 100 and over 1.");
            $rest = "Number not allowed, must be under 100 and over 1.";
            $_SESSION["tries"] = $_SESSION["tries"] - 1;
        } else {
            $rest = "Your guess " . $guessNum . " is " . $res;
            $_SESSION["tries"] = $_SESSION["tries"] - 1;
        }?>
    <?php endif; ?>
    <?php if ($action == "Cheat") : ?>
        <?php $rest = "The answer is: " . $secret; ?>
    <?php endif; ?>
    <?php
    if ($action == "Reset") {
        session_unset();
    }

    $data = [
        "tries" => $tries,
        "rest" => $rest
    ];
    $app->page->add("guess/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


