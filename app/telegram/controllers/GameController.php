<?php

namespace tlg\telegram\controllers;

use tlg\telegram\models\User;
use tlg\telegram\controllers\game\SearchController;
use tlg\telegram\controllers\game\ChooseGameController;

class GameController
{
    public static function identify()
    {
        switch (User::getMethod()) {
            case 'search_game': SearchController::identify(); break;
            case 'choose_game': ChooseGameController::identify(); break;
        }
    }
}
