<?php

namespace tlg\telegram\controllers;

use tlg\telegram\TLG;
use tlg\telegram\tables\User;
use tlg\telegram\parse\PMessage;
use tlg\telegram\helpers\MethodHelpers;
use tlg\telegram\helpers\KeyboardHelpers;
use tlg\telegram\controllers\game\PlayController;
use tlg\telegram\controllers\game\SearchController;
use tlg\telegram\controllers\game\ChooseController;

class MethodController
{
    public static function identify()
    {
        echo 'MethodController: Method - ' . User::getMethod() . '<br>';

        if (User::getMethod() === 'played') {
            PlayController::move();
            return;
        }

        if (PMessage::$command === '/home') {
            User::sqlUpdateMethod();
            BasicController::home();
        }

        switch (User::getMethod()) {
            case MethodHelpers::GAME_SEARCH: SearchController::identify(); break;
            case MethodHelpers::GAME_CHOOSE: ChooseController::identify(); break;
            default: SearchController::identify();
        }
    }

    public static function home()
    {
        TLG::sendMessage('Home page', KeyboardHelpers::home());
        User::sqlUpdateMethod();
    }
}
