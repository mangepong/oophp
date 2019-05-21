<?php


/**
 * Init the game and redirect to play the game
 */
$app->router->get("dice/init", function () use ($app) {
    // init the session for the gamestart
    $_SESSION["turn"] = "Spelare 1";
    $_SESSION["object"] = new Emmu18\Dice\Dice();
    $_SESSION["score1"] = 0;
    $_SESSION["score2"] = 0;
    $_SESSION["mode"] = "enabled";
    return $app->response->redirect("dice/play");
});


$app->router->get("dice/play", function () use ($app) {
    // echo "Some debugging information";
    $title = "Play the game";
    $action = $_GET["action"] ?? "";
    $object = $_SESSION["object"];
    $rest = "";
    $turn = $_SESSION["turn"];
    $dices = [];

    if ($action == "Kasta") {
        $object->rollDice();
        $rest = $object->printDices();
        $dices = $object->getDices();
        if ($turn == "Spelare 1") {
            if ($dices[0] == 1 || $dices[1] == 1 || $dices[2] == 1) {
                $_SESSION["turn"] = "Spelare 2";
            }
        } elseif ($turn == "Spelare 2") {
            if ($dices[0] == 1 || $dices[1] == 1 || $dices[2] == 1) {
                $_SESSION["turn"] = "Spelare 1";
            }
        }
    }

    if ($action == "Spara") {
        $rest = $object->printDices();
        $dices = $object->getDices();
        if ($turn == "Spelare 1") {
            $_SESSION["turn"] = "Spelare 2";
            if ($dices[0] != 1 && $dices[1] != 1 && $dices[2] != 1) {
                $_SESSION["score1"] += $dices[0] + $dices[1] + $dices[2];
                if ($_SESSION["score1"] >= 100) {
                    $rest = "Spelare 1 vann!";
                    $_SESSION["mode"] = "disabled";
                }
            }
        } else {
            $_SESSION["turn"] = "Spelare 1";
            if ($dices[0] != 1 && $dices[1] != 1 && $dices[2] != 1) {
                $_SESSION["score2"] += $dices[0] + $dices[1] + $dices[2];
                if ($_SESSION["score2"] >= 100) {
                    $rest = "Spelare 2 vann!";
                    $_SESSION["mode"] = "disabled";
                }
            }
        }
    }

    if ($action == "Starta Om") {
        return $app->response->redirect("dice/init");
    }

    $score1 = $_SESSION["score1"];
    $score2 = $_SESSION["score2"];

    $data = [
        "rest" => $rest,
        "turn" => $turn,
        "score1" => $score1,
        "score2" => $score2
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
