<?php

namespace Emmu18\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //
    //     // Use $this->app to access the framework services.
    // }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        // init the session for the gamestart
        // $_SESSION["turn"] = "Spelare 1";
        // $_SESSION["object"] = new Dice();
        // $_SESSION["score1"] = 0;
        // $_SESSION["score2"] = 0;
        // $_SESSION["mode"] = "enabled";
        $this->app->session->set("turn", "Spelare 1");
        $this->app->session->set("object", new Dice());
        $this->app->session->set("score1", 0);
        $this->app->session->set("score2", 0);
        $_SESSION["mode"] = "enabled";

        return $this->app->response->redirect("dice1/play");
    }

    public function playAction() : object
    {
        // echo "Some debugging information";
        $title = "Play the game";
        $action = $_GET["action"] ?? "";
        $object = $this->app->session->get("object");
        $rest = "";
        $turn = $this->app->session->get("turn");
        $dices = [];
        $total = 0;

        if ($action == "Kasta") {
            $object->rollDice();
            $rest = $object->printDices();
            $dices = $object->getDices();
            if ($turn == "Spelare 1") {
                if ($dices[0] == 1 || $dices[1] == 1 || $dices[2] == 1) {
                    $this->app->session->set("turn", "Datorn");
                    // $_SESSION["turn"] = "Datorn";
                    // $turn = $_SESSION["turn"];
                    $turn = $this->app->session->get("turn");
                }
            } elseif ($turn == "Datorn") {
                if ($dices[0] == 1 || $dices[1] == 1 || $dices[2] == 1) {
                    $this->app->session->set("turn", "Spelare 1");
                    // $_SESSION["turn"] = "Spelare 1";
                    // $turn = $_SESSION["turn"];
                    $turn = $this->app->session->get("turn");
                } else {
                    // $_SESSION["score2"] += $dices[0] + $dices[1] + $dices[2];
                    $total = $dices[0] + $dices[1] + $dices[2];
                    $this->app->session->set("score2", $total + $this->app->session->get("score2"));
                    $this->app->session->set("turn", "Spelare 1");
                    // $_SESSION["turn"] = "Spelare 1";
                    // $turn = $_SESSION["turn"];
                    $turn = $this->app->session->get("turn");
                    if ($this->app->session->get("score2") >= 100) {
                        $rest = "Datorn vann!";
                        $_SESSION["mode"] = "disabled";
                    }
                }
            }
        }

        if ($action == "Spara") {
            // $rest = $object->printDices();
            $dices = $object->getDices();
            if ($turn == "Spelare 1") {
                $this->app->session->set("turn", "Datorn");
                // $_SESSION["turn"] = "Datorn";
                // $turn = $_SESSION["turn"];
                $turn = $this->app->session->get("turn");
                if ($dices[0] != 1 && $dices[1] != 1 && $dices[2] != 1) {
                    // $_SESSION["score1"] += $dices[0] + $dices[1] + $dices[2];
                    $total = $dices[0] + $dices[1] + $dices[2];
                    $this->app->session->set("score1", $total + $this->app->session->get("score1"));
                    if ($this->app->session->get("score1") >= 100) {
                        $rest = "Spelare 1 vann!";
                        $_SESSION["mode"] = "disabled";
                    }
                }
            }
        }

        if ($action == "Starta Om") {
            return $this->app->response->redirect("dice1/init");
        }
        $dice = new DiceHistogram();
        $score1 = $this->app->session->get("score1");
        $score2 = $this->app->session->get("score2");


        // $dice->printHistogram($object->getDices());

        $data = [
            "rest" => $rest,
            "turn" => $turn,
            "score1" => $score1,
            "score2" => $score2,
            "object" => $object,
            "dice" => $dice
        ];

        $this->app->page->add("dice1/play", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "INDEX";
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug my game";
    }
}
