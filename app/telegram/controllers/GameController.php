<?php

namespace tlg\telegram\controllers;

use tlg\telegram\models\User;
use tlg\telegram\helpers\MethodHelpers;
use tlg\telegram\controllers\game\SearchController;
use tlg\telegram\controllers\game\ChooseController;

class GameController
{
    public static function identify()
    {
        echo 'GameController' . '<br>';

        switch (User::getMethod()) {
            case MethodHelpers::SEARCH_GAME: SearchController::identify(); break;
            case MethodHelpers::CHOOSE_GAME: ChooseController::identify(); break;
        }
    }
}
